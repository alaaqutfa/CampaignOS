<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\City;
use App\Models\Region;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CampaignItemController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorize('view', $campaign);
        $items = CampaignItem::where('campaign_id', $campaign->id)
            ->with(['shop.city', 'shop.region', 'recordedBy', 'assets', 'assignedMeasurer', 'assignedInstaller'])
            ->paginate(100);
        $cities = CampaignItem::where('campaign_id', $campaign->id)
            ->with('shop.city')
            ->get()
            ->pluck('shop.city')
            ->filter()
            ->unique('id')
            ->values();
        return view('campaigns.show', compact('campaign', 'items', 'cities'));
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('addMeasurement', $campaign);
        $companyId  = Auth::user()->company_id;
        $shops      = Shop::where('company_id', $companyId)->with('city', 'region')->get();
        $measurers  = User::where('company_id', $companyId)->role('measurer')->get();
        $installers = User::where('company_id', $companyId)->role('installer')->get();

        return view('campaigns.items.create', compact('campaign', 'shops', 'measurers', 'installers'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('addMeasurement', $campaign);

        $validated = $request->validate([
            'shop_id'               => 'required|exists:shops,id',
            'material'              => 'required|string|max:255',
            'quantity'              => 'required|integer|min:1',
            'width'                 => 'required|numeric|min:0.01',
            'height'                => 'required|numeric|min:0.01',
            'unit'                  => 'required|in:cm,inch,pixel',
            'text'                  => 'nullable|string',
            'notes'                 => 'nullable|string',
            'assigned_measurer_id'  => 'nullable|exists:users,id',
            'assigned_installer_id' => 'nullable|exists:users,id',
        ]);

        $sqm = ($validated['width'] * $validated['height'] * $validated['quantity']) / 10000;

        $printFileName = $this->generatePrintFileName($campaign, $validated);

        $item = $campaign->items()->create([
            'shop_id'               => $validated['shop_id'],
            'material'              => $validated['material'],
            'quantity'              => $validated['quantity'],
            'width'                 => $validated['width'],
            'height'                => $validated['height'],
            'unit'                  => $validated['unit'],
            'text'                  => $validated['text'],
            'print_file_name'       => $printFileName,
            'sqm'                   => $sqm,
            'recorded_by'           => Auth::user()->id,
            'notes'                 => $validated['notes'],
            'status'                => 'pending',
            'assigned_measurer_id'  => $validated['assigned_measurer_id'],
            'assigned_installer_id' => $validated['assigned_installer_id'],
        ]);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Measurement added successfully.');
    }

    public function edit(Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('update', $item);
        $companyId  = Auth::user()->company_id;
        $shops      = Shop::where('company_id', $companyId)->with('city', 'region')->get();
        $measurers  = User::where('company_id', $companyId)->role('measurer')->get();
        $installers = User::where('company_id', $companyId)->role('installer')->get();

        return view('campaigns.items.edit', compact('campaign', 'item', 'shops', 'measurers', 'installers'));
    }

    public function update(Request $request, Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('update', $item);

        // لا يمكن تعديل القياس بعد التركيب أو الرفض
        // if (! in_array($item->status, ['pending', 'designed', 'printed'])) {
        //     return redirect()->back()->with('error', 'Cannot edit measurement after installation or rejection.');
        // }

        $validated = $request->validate([
            'shop_id'               => 'required|exists:shops,id',
            'material'              => 'required|string|max:255',
            'quantity'              => 'required|integer|min:1',
            'width'                 => 'required|numeric|min:0.01',
            'height'                => 'required|numeric|min:0.01',
            'unit'                  => 'required|in:cm,inch,pixel',
            'text'                  => 'nullable|string',
            'notes'                 => 'nullable|string',
            'assigned_measurer_id'  => 'nullable|exists:users,id',
            'assigned_installer_id' => 'nullable|exists:users,id',
        ]);

        $sqm = ($validated['width'] * $validated['height'] * $validated['quantity']) / 10000;

        $item->update([
            'shop_id'               => $validated['shop_id'],
            'material'              => $validated['material'],
            'quantity'              => $validated['quantity'],
            'width'                 => $validated['width'],
            'height'                => $validated['height'],
            'unit'                  => $validated['unit'],
            'text'                  => $validated['text'],
            'sqm'                   => $sqm,
            'notes'                 => $validated['notes'],
            'assigned_measurer_id'  => $validated['assigned_measurer_id'],
            'assigned_installer_id' => $validated['assigned_installer_id'],
        ]);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Measurement updated successfully.');
    }

    public function destroy(Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Measurement deleted successfully.');
    }

    protected function generatePrintFileName($campaign, $data)
    {
        $shop = Shop::find($data['shop_id']);
        return sprintf(
            '%s - %s - %sx%s - %s',
            $campaign->title,
            $shop->name,
            $data['width'],
            $data['height'],
            $data['material']
        );
    }

    public function bulkImport(Request $request, Campaign $campaign)
    {
        $this->authorize('addMeasurement', $campaign);

        $request->validate([
            'files'   => 'required|array',
            'files.*' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        $companyId     = Auth::user()->company_id;
        $importedCount = 0;
        $errors        = [];

        // Define allowed status values (matching the CampaignItem model 'status' enum)
        $allowedStatuses = ['pending', 'measured', 'designed', 'printed', 'installed', 'rejected'];

        foreach ($request->file('files') as $file) {
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet       = $spreadsheet->getSheetByName('Design');
            if (! $sheet) {
                $sheet = $spreadsheet->getActiveSheet();
            }
            $rows = $sheet->toArray();

            // Remove header row
            $headers = array_shift($rows);
            // Optionally validate headers here (skip if not matching expected)

            foreach ($rows as $rowIndex => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Extract data by column index
                $cityName      = trim($row[0] ?? '');
                $address       = trim($row[1] ?? '');
                $shopName      = trim($row[2] ?? '');
                $width         = (float) ($row[3] ?? 0);
                $height        = (float) ($row[4] ?? 0);
                $quantity      = (int) ($row[5] ?? 0);
                $material      = trim($row[6] ?? '');
                $sqmFromFile   = (float) ($row[7] ?? 0); // not used, we recalculate
                $text          = trim($row[8] ?? '');
                $printFileName = trim($row[9] ?? '');
                $statusRaw     = trim($row[10] ?? '');

                // Determine status: use provided value if valid, otherwise 'pending'
                $status = 'pending';
                if (! empty($statusRaw) && in_array(strtolower($statusRaw), $allowedStatuses)) {
                    $status = strtolower($statusRaw);
                } elseif (! empty($statusRaw)) {
                    $errors[] = "Row " . ($rowIndex + 2) . " in file {$file->getClientOriginalName()}: Invalid status value '$statusRaw', defaulting to 'pending'.";
                }

                // Validate required fields
                if (! $cityName || ! $shopName || $width <= 0 || $height <= 0 || $quantity <= 0 || ! $material) {
                    $errors[] = "Row " . ($rowIndex + 2) . " in file {$file->getClientOriginalName()}: Missing required data (City, Shop Name, Width, Height, Quantity, Material).";
                    continue;
                }

                // Find or create city
                $city = City::firstOrCreate([
                    'name'       => $cityName,
                    'company_id' => $companyId,
                ]);

                // Find or create region (based on address)
                $region = null;
                if ($address) {
                    $region = Region::firstOrCreate([
                        'name'    => $address,
                        'city_id' => $city->id,
                    ]);
                }

                // Find or create shop
                $shop = Shop::where('company_id', $companyId)
                    ->where('name', $shopName)
                    ->where('city_id', $city->id)
                    ->first();
                if (! $shop) {
                    $shop = Shop::create([
                        'name'       => $shopName,
                        'city_id'    => $city->id,
                        'region_id'  => $region ? $region->id : null,
                        'address'    => $address,
                        'company_id' => $companyId,
                    ]);
                } else {
                    // Optionally update shop address/region if changed
                    if ($address && $shop->address != $address) {
                        $shop->address = $address;
                    }
                    if ($region && $shop->region_id != $region->id) {
                        $shop->region_id = $region->id;
                    }
                    $shop->save();
                }

                // Calculate SQM: (width * height * quantity) / 10000
                $calculatedSqm = ($width * $height * $quantity) / 10000;

                // Generate print file name if not provided
                if (empty($printFileName)) {
                    $printFileName  = $this->generatePrintFileName($campaign, [
                        'shop_id'  => $shop->id,
                        'material' => $material,
                        'width'    => $width,
                        'height'   => $height,
                    ]);
                    $printFileName .= " - QTY{$quantity}";
                }

                // Check for duplicate (same shop, dimensions, material, quantity) within the same campaign
                $exists = CampaignItem::where('campaign_id', $campaign->id)
                    ->where('shop_id', $shop->id)
                    ->where('width', $width)
                    ->where('height', $height)
                    ->where('material', $material)
                    ->where('quantity', $quantity)
                    ->exists();
                if ($exists) {
                    $errors[] = "Row " . ($rowIndex + 2) . " in file {$file->getClientOriginalName()}: Duplicate measurement (same shop, dimensions, material, quantity) already exists in this campaign.";
                    continue;
                }

                // Create the campaign item
                try {
                    $campaign->items()->create([
                        'shop_id'               => $shop->id,
                        'material'              => $material,
                        'quantity'              => $quantity,
                        'width'                 => $width,
                        'height'                => $height,
                        'unit'                  => 'cm',
                        'text'                  => $text,
                        'print_file_name'       => $printFileName,
                        'sqm'                   => $calculatedSqm,
                        'recorded_by'           => Auth::user()->id,
                        'notes'                 => '',
                        'status'                => $status,
                        'assigned_measurer_id'  => null,
                        'assigned_installer_id' => null,
                    ]);
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($rowIndex + 2) . " in file {$file->getClientOriginalName()}: Save error - " . $e->getMessage();
                }
            }
        }

        $message = "Successfully imported {$importedCount} measurements.";
        if (! empty($errors)) {
            // Store full errors array in session for detailed display, but show a summary in flash
            return redirect()->route('campaigns.show', $campaign)
                ->with('warning', $message . ' However, some errors occurred: ' . implode('; ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? ' ...' : ''))
                ->with('errors_details', $errors);
        }

        if ($request->ajax()) {
            return response()->json([
                'success'  => empty($errors),
                'imported' => $importedCount,
                'errors'   => $errors,
            ]);
        }

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', $message);
    }

    public function export(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $items = $campaign->items()->with(['shop.city', 'shop.region'])->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Design');

        $headers = [
            'A1' => 'City',
            'B1' => 'Address',
            'C1' => 'Shop Name',
            'D1' => 'W (cm)',
            'E1' => 'H (cm)',
            'F1' => 'QTY',
            'G1' => 'Material',
            'H1' => 'SQM',
            'I1' => 'Text',
            'J1' => 'Print file name',
            'K1' => 'Status',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        $row = 2;
        foreach ($items as $item) {
            $cityName      = $item->shop->city->name ?? '';
            $address       = $item->shop->address ?? ($item->shop->region->name ?? '');
            $shopName      = $item->shop->name;
            $width         = $item->width;
            $height        = $item->height;
            $qty           = $item->quantity;
            $material      = $item->material;
            $sqm           = $item->sqm;
            $text          = $item->text;
            $printFileName = $item->print_file_name;
            $status        = $this->getStatusText($item->status); // ترجمة الحالة

            $sheet->setCellValue("A{$row}", $cityName);
            $sheet->setCellValue("B{$row}", $address);
            $sheet->setCellValue("C{$row}", $shopName);
            $sheet->setCellValue("D{$row}", $width);
            $sheet->setCellValue("E{$row}", $height);
            $sheet->setCellValue("F{$row}", $qty);
            $sheet->setCellValue("G{$row}", $material);
            $sheet->setCellValue("H{$row}", $sqm);
            $sheet->setCellValue("I{$row}", $text);
            $sheet->setCellValue("J{$row}", $printFileName);
            $sheet->setCellValue("K{$row}", $status);
            $row++;
        }

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer   = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = "{$campaign->client_id}: measurements of {$campaign->title} campaign .xlsx";

        return new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    private function getStatusText($status)
    {
        $map = [
            'pending'   => 'Pending',
            'designed'  => 'Designed',
            'printed'   => 'Printed',
            'installed' => 'Installed',
            'rejected'  => 'Rejected',
        ];
        return $map[$status] ?? $status;
    }

    public function bulkUpdateStatus(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $request->validate([
            'item_ids'   => 'required|array',
            'item_ids.*' => 'exists:campaign_items,id',
            'status'     => 'required|in:pending,measured,designed,printed,installed,rejected',
        ]);

        $updated = CampaignItem::whereIn('id', $request->item_ids)
            ->where('campaign_id', $campaign->id)
            ->update(['status' => $request->status]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'updated' => $updated]);
        }

        return redirect()->back()->with('success', "{$updated} items updated to {$request->status}.");
    }

    public function bulkUpdateAllStatus(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $request->validate([
            'status' => 'required|in:pending,measured,designed,printed,installed,rejected',
        ]);

        $updated = $campaign->items()->update(['status' => $request->status]);

        // if ($request->ajax()) {
        // }
        return response()->json(['success' => true, 'updated' => $updated]);

        // return redirect()->back()->with('success', "All {$updated} items updated to {$request->status}.");
    }

}
