<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class NotificationService
{
    /**
     * Send a notification to a user.
     */
    public static function sendToUser(User $user, Notification $notification)
    {
        $user->notify($notification);
    }

    /**
     * Send a notification to multiple users.
     */
    public static function sendToUsers($users, Notification $notification)
    {
        NotificationFacade::send($users, $notification);
    }

    /**
     * Mark a notification as read.
     */
    public static function markAsRead($notificationId)
    {
        $user = auth()->user();
        $notification = $user->notifications()->where('id', $notificationId)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }
}
