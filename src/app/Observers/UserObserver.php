<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        // $user->available_credits = 5;
    }

    public function created(User $user)
    {
        $userRole = Role::where('slug', 'user')->first();

        if ($userRole) {
            $user->roles()->attach($userRole->id);
        }
    }
}
