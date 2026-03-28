<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Subscription::class);
        $company = Auth::user()->company;
        $subscriptions = $company->subscriptions()->with('plan')->latest()->get();
        $activeSubscription = $company->activeSubscription;

        return view('company.subscriptions.index', compact('subscriptions', 'activeSubscription'));
    }

    public function create()
    {
        $this->authorize('create', Subscription::class);
        $plans = Plan::where('is_active', true)->get();
        return view('company.subscriptions.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Subscription::class);
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $company = Auth::user()->company;

        // منع طلب اشتراك مزدوج pending
        if ($company->subscriptions()->where('status', 'pending')->exists()) {
            return redirect()->route('company.subscriptions.index')
                ->with('error', 'You already have a pending subscription request.');
        }

        $company->subscriptions()->create([
            'plan_id' => $plan->id,
            'status'  => 'pending',
            'auto_renew' => true,
        ]);

        return redirect()->route('company.subscriptions.index')
            ->with('success', 'Subscription request submitted. Please wait for admin approval.');
    }

    public function show(Subscription $subscription)
    {
        $this->authorize('view', $subscription);
        $company = Auth::user()->company;
        if ($subscription->company_id !== $company->id) {
            abort(403);
        }
        return view('company.subscriptions.show', compact('subscription'));
    }
}
