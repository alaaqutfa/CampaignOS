<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CampaignItem;
use App\Models\MeasurementAsset;
use App\Models\Region;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ContractorApiController extends Controller
{
    /**
     * تسجيل دخول المقاول (measurer أو installer)
     * POST /api/contractor/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            // التأكد من أن المستخدم له دور measurer أو installer
            if (! $user->hasRole(['measurer', 'installer'])) {
                return response()->json(['error' => 'Unauthorized role'], 403);
            }
            // حذف أي توكينات سابقة (اختياري)
            $user->tokens()->delete();
            // إنشاء توكين جديد
            $token = $user->createToken('contractor-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user'  => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->getRoleNames()->first(),
                ],
            ]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    /**
     * تسجيل الخروج
     * POST /api/contractor/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * الحصول على بيانات المستخدم الحالي
     * GET /api/contractor/me
     */
    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->getRoleNames()->first(),
        ]);
    }

    /**
     * جلب المناطق المسندة للمقاول (حسب دور measurer/installer)
     * GET /api/contractor/regions
     */
    public function regions(Request $request)
    {
        $user = $request->user();
        // جلب المناطق التي تم تعيينه فيها مع نوع المهمة
        $regions = $user->assignedRegions()->with('city')->get();
        return response()->json($regions);
    }

    /**
     * جلب المحلات التابعة لمنطقة معينة (مع إمكانية إضافة محل جديد)
     * GET /api/contractor/regions/{region}/shops
     */
    public function shops(Region $region, Request $request)
    {
        $user = $request->user();
        // التأكد من أن المستخدم مسند لهذه المنطقة
        if (! $user->assignedRegions->contains($region->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $shops = $region->shops()->with('campaignItems')->get();
        return response()->json($shops);
    }

    /**
     * إضافة محل جديد في منطقة مسندة
     * POST /api/contractor/regions/{region}/shops
     */
    public function storeShop(Request $request, Region $region)
    {
        $user = $request->user();
        if (! $user->assignedRegions->contains($region->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $shop = Shop::create([
            'company_id' => $user->company_id,
            'city_id'    => $region->city_id,
            'region_id'  => $region->id,
            'name'       => $request->name,
            'address'    => $request->address,
        ]);

        return response()->json($shop, 201);
    }

    /**
     * جلب مهام القياس للمقاول (حالة pending فقط أو حسب الحاجة)
     * GET /api/contractor/measurement-tasks
     */
    public function measurementTasks(Request $request)
    {
        $user  = $request->user();
        $tasks = CampaignItem::where('assigned_measurer_id', $user->id)
            ->with(['campaign', 'shop.region', 'shop.city', 'assets'])
            ->get();

        return response()->json($tasks);
    }

    /**
     * إضافة قياسات لعنصر حملة
     * POST /api/contractor/measurement-tasks/{item}
     */
    public function storeMeasurement(Request $request, CampaignItem $item)
    {
        $user = $request->user();

        // التحقق من صلاحيات المقاول (سياسة CampaignItemPolicy تسمح للمكلف بالقياس)
        if ($item->assigned_measurer_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'width'    => 'required|numeric',
            'height'   => 'required|numeric',
            'unit'     => 'required|in:cm,inch,pixel',
            'material' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'text'     => 'nullable|string',
            'image'    => 'nullable|image|max:10240',
        ]);

        // تحديث بيانات القياس في CampaignItem
        $item->update([
            'width'    => $request->width,
            'height'   => $request->height,
            'unit'     => $request->unit,
            'material' => $request->material,
            'quantity' => $request->quantity,
            'text'     => $request->text,
            'status'   => 'measured',
        ]);

        // رفع الصورة (صورة قبل)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('measurements', 'public');
            MeasurementAsset::create([
                'campaign_item_id' => $item->id,
                'type'             => 'before',
                'file_path'        => $path,
                'original_name'    => $request->file('image')->getClientOriginalName(),
                'mime_type'        => $request->file('image')->getMimeType(),
                'size'             => $request->file('image')->getSize(),
                'uploaded_by'      => $user->id,
                'captured_at'      => Carbon::now(),
            ]);
        }

        return response()->json(['message' => 'Measurement saved successfully', 'item' => $item]);
    }

    /**
     * جلب مهام التركيب للمقاول (حالة printed فقط أو حسب الحاجة)
     * GET /api/contractor/installation-tasks
     */
    public function installationTasks(Request $request)
    {
        $user  = $request->user();
        $tasks = CampaignItem::where('assigned_installer_id', $user->id)
            ->whereIn('status', ['printed', 'designed']) // يمكن تعديل الحالات حسب العملية
            ->with(['campaign', 'shop.region', 'shop.city', 'assets'])
            ->get();

        return response()->json($tasks);
    }

    /**
     * تحديث حالة التركيب (رفع صور قبل/بعد)
     * POST /api/contractor/installation-tasks/{item}
     */
    public function storeInstallation(Request $request, CampaignItem $item)
    {
        $user = $request->user();
        if ($item->assigned_installer_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status'         => 'required|in:installed,failed',
            'failure_reason' => 'required_if:status,failed|nullable|string',
            'before_image'   => 'nullable|image|max:10240',
            'after_image'    => 'nullable|image|max:10240',
        ]);

        $item->status = $request->status;
        if ($request->status === 'failed') {
            $item->failure_reason = $request->failure_reason;
        } else {
            $item->installed_by = $user->id;
            $item->installed_at = Carbon::now();
        }
        $item->save();

        // رفع الصورة قبل التركيب
        if ($request->hasFile('before_image')) {
            $path = $request->file('before_image')->store('measurements', 'public');
            MeasurementAsset::create([
                'campaign_item_id' => $item->id,
                'type'             => 'before',
                'file_path'        => $path,
                'original_name'    => $request->file('before_image')->getClientOriginalName(),
                'mime_type'        => $request->file('before_image')->getMimeType(),
                'size'             => $request->file('before_image')->getSize(),
                'uploaded_by'      => $user->id,
                'captured_at'      => Carbon::now(),
            ]);
        }

        // رفع الصورة بعد التركيب
        if ($request->hasFile('after_image')) {
            $path = $request->file('after_image')->store('measurements', 'public');
            MeasurementAsset::create([
                'campaign_item_id' => $item->id,
                'type'             => 'after',
                'file_path'        => $path,
                'original_name'    => $request->file('after_image')->getClientOriginalName(),
                'mime_type'        => $request->file('after_image')->getMimeType(),
                'size'             => $request->file('after_image')->getSize(),
                'uploaded_by'      => $user->id,
                'captured_at'      => Carbon::now(),
            ]);
        }

        return response()->json(['message' => 'Installation updated successfully', 'item' => $item]);
    }
}
