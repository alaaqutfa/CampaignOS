<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Subscription::class);
        $subscriptions = Subscription::with(['company', 'plan'])
            ->latest()
            ->paginate(20);
        return view('super-admin.subscriptions.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription)
    {
        return view('super-admin.subscriptions.show', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $this->authorize('update', $subscription);
        $request->validate([
            'status' => 'required|in:active,cancelled',
        ]);

        if ($request->status === 'active') {
            // إن لم يكن له تاريخ بدء، حدده الآن
            if (! $subscription->start_date) {
                $subscription->start_date = Carbon::now();
                $subscription->end_date   = $subscription->plan->billing_cycle === 'monthly'
                    ? Carbon::now()->addMonth()
                    : Carbon::now()->addYear();
            }
            // إلغاء أي اشتراك نشط سابق للشركة
            Subscription::where('company_id', $subscription->company_id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);
        }

        $subscription->status = $request->status;
        $subscription->save();

        return redirect()->route('super-admin.subscriptions.index')
            ->with('success', 'Subscription updated successfully.');
    }

    public function destroy(Subscription $subscription)
    {
        $this->authorize('delete', $subscription);
        $subscription->delete();
        return redirect()->route('super-admin.subscriptions.index')
            ->with('success', 'Subscription deleted.');
    }
}
