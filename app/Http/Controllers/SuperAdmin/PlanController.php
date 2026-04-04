<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StorePlanRequest;
use App\Http\Requests\SuperAdmin\UpdatePlanRequest;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->paginate(20);
        return view('super-admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('super-admin.plans.create');
    }

    public function store(StorePlanRequest $request)
    {
        Plan::create($request->validated());

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        return view('super-admin.plans.edit', compact('plan'));
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->validated());

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Plan deleted successfully.');
    }
}
