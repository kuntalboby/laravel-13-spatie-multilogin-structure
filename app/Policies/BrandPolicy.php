<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{
    /**
     * Create a new policy instance.
     */
        public function edit(User $user , Brand $brand): bool
    {
        //  if ($user->role === 'admin') {
        //     return true;
        //  }
        // return $user->hasPermissionTo('brand.update') && $user->id === $brand->user_id;
        return true;

        

    }
    public function delete(User $user , Brand $brand): bool
    {
        //  if ($user->role === 'admin') {
        //     return true;
        //  }
        // return $user->hasPermissionTo('brand.delete') && $user->id === $brand->user_id;
        return true;
    }

}
