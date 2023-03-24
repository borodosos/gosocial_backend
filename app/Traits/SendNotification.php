<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\RealTimeNotification;

trait SendNotification
{
    public function sendNotification($id)
    {
        $user = User::find($id);
        $notification = new RealTimeNotification('Message from ' . $user->first_name . ' ' . $user->second_name);

        $user->notify($notification);
    }
}
