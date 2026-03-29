<?php
namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorAssignmentController extends Controller
{

    /**
     * عرض قائمة المقاولين (measurer, installer)
     */
    public function index()
    {
        $companyId   = Auth::user()->company_id;
        $contractors = User::where('company_id', $companyId)
            ->role(['measurer', 'installer'])
            ->with('assignedRegions')
            ->get();

        return view('contractor-assignments.index', compact('contractors'));
    }

    /**
     * عرض نموذج تعيين مناطق لمقاول معين
     */
    public function edit(User $contractor)
    {
        // $this->authorize('update', $contractor); // استخدام UserPolicy

        $companyId = Auth::user()->company_id;
        $regions   = Region::whereHas('city', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->with('city')->get();

        $assignedRegions = $contractor->assignedRegions->pluck('id')->toArray();
        $assignmentTypes = $contractor->assignedRegions->mapWithKeys(function ($region) {
            return [$region->id => $region->pivot->assignment_type];
        })->toArray();

        return view('contractor-assignments.edit', compact('contractor', 'regions', 'assignedRegions', 'assignmentTypes'));
    }

    /**
     * تحديث تعيينات المناطق للمقاول
     */
    public function update(Request $request, User $contractor)
    {
        // $this->authorize('update', $contractor);

        $request->validate([
            'regions'            => 'array',
            'regions.*'          => 'exists:regions,id',
            'assignment_types'   => 'array',
            'assignment_types.*' => 'in:measure,install,both',
        ]);

        // مزامنة المناطق مع نوع المهمة
        $syncData = [];
        if ($request->has('regions')) {
            foreach ($request->regions as $regionId) {
                $type                = $request->assignment_types[$regionId] ?? 'both';
                $syncData[$regionId] = ['assignment_type' => $type];
            }
        }
        $contractor->assignedRegions()->sync($syncData);

        return redirect()->route('contractor-assignments.index')
            ->with('success', 'Region assignments updated successfully.');
    }
}
