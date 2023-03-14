<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\RealTimeNotification;

trait SendNotification
{
    public function sendNotification($id)
    {
        $user = User::find($id);
        $notification = new RealTimeNotification('Hi!');

        $user->notify($notification);
    }
}
