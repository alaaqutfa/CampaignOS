<?php
namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can view any subscriptions.
     * السوبر أدمن يرى كل الاشتراكات، ومدير الشركة يرى اشتراكات شركته فقط.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('company_admin');
    }

    /**
     * Determine whether the user can view the subscription.
     */
    public function view(User $user, Subscription $subscription): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // مدير الشركة يمكنه رؤية اشتراكات شركته فقط
        if ($user->hasRole('company_admin')) {
            return $user->company_id === $subscription->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create a subscription (request a new subscription).
     * فقط مدير الشركة يمكنه تقديم طلب اشتراك لشركته.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('company_admin');
    }

    /**
     * Determine whether the user can update the subscription.
     * فقط السوبر أدمن يمكنه تحديث حالة الاشتراك (تنشيط، إلغاء، إلخ).
     */
    public function update(User $user, Subscription $subscription): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can delete the subscription.
     * فقط السوبر أدمن يمكنه حذف الاشتراكات.
     */
    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->hasRole('super_admin');
    }
}
