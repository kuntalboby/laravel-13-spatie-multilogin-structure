<?php

namespace App\Policies;

use App\Models\Size;
use App\Models\User;

class SizePolicy
{
    /**
     * Create a new policy instance.
     */
        public function edit(User $user , Size $size): bool
    {
        //  if ($user->role === 'admin') {
        //     return true;
        //  }
        // return $user->hasPermissionTo('size.update') && $user->id === $size->user_id;
        return true;

        

    }
    public function delete(User $user , Size $size): bool
    {
        //  if ($user->role === 'admin') {
        //     return true;
        //  }
        // return $user->hasPermissionTo('size.delete') && $user->id === $size->user_id;
        return true;
    }
}

