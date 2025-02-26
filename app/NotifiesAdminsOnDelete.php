<?php

namespace App;

use App\Models\User;
use App\Notifications\ModelUpdateNotification;
use App\Models\Role;
use App\Notifications\UserApproved;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\WebPush\WebPushChannel;

trait NotifiesAdminsOnDelete
{


    public static function bootNotifiesAdminsOnDelete()
    {
        static::created(function ($model) {
            // Get the authenticated user who created the record
            $user = auth()->user();

            $role = Role::where('name', 'admin')->first();
            $link = route('app.notifications');

            // If the role exists, send the notification with afterCommit
            if ($role && $user) {
                $role->notify(new ModelUpdateNotification($user, $model, 'created', $link, ['database']));
                $user->notify(new ModelUpdateNotification($user, $model, 'created', $link,  ['database']));
                Notification::sendNow($role->users, new ModelUpdateNotification($user, $model, 'created', $link,  [WebPushChannel::class]));
            }
        });
        static::updating(function ($model) {
            // Get the authenticated user who is performing the action
            $user = auth()->user();

            // Capture the original model data before the update
            $role = Role::where('name', 'admin')->first();
            $link = route('app.notifications');

            // If the role exists, send the notification with afterCommit
            if ($role && $user) {
                $role->notify(new ModelUpdateNotification($user, $model, 'edited', $link,  ['database']));
                $user->notify(new ModelUpdateNotification($user, $model, 'edited', $link,  ['database']));
                Notification::sendNow($role->users, new ModelUpdateNotification($user, $model, 'edited', $link,  [WebPushChannel::class]));
            }
        });

        static::deleting(function ($model) {
            // Get the authenticated user who is deleting the record
            $user = auth()->user();
            // Find the role that should be notified (e.g., Admin role)
            $role = Role::where('name', 'admin')->first();
            $link = route('app.notifications');

            // If the role exists, send the notification
            if ($role && $user) {
//                $role->notify((new ModelUpdateNotification($user, $model, 'deleted')));
                Notification::sendNow($role, new ModelUpdateNotification($user, $model, 'deleted', $link, ['database']));
                Notification::sendNow($user, new ModelUpdateNotification($user, $model, 'deleted', $link, ['database']));
                Notification::sendNow($role->users, new ModelUpdateNotification($user, $model, 'deleted', $link,  [WebPushChannel::class]));

            }
        });
    }
}
