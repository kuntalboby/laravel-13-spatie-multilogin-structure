<?php

namespace App\Policies;

use App\Models\Color;
use App\Models\User;

class ColorPolicy
{
    /**
     * Create a new policy instance.
     */
        public function edit(User $user , Color $color): bool
        {
            return true;
        //  if ($user->role === 'admin') {
        //     return true;
        //  }
        // return $user->hasPermissionTo('color.update') && $user->id === $color->user_id;

        

    }
    public function delete(User $user , Color $color): bool
    {
        //  if ($user->role === 'admin') {
        //     return true;
        //  }
        // return $user->hasPermissionTo('color.delete') && $user->id === $color->user_id;
        return true;
    }
}

