<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function edit(User $user , Category $category): bool
    {
         if ($user->role === 'admin') {
            return true;
         }
        return $user->hasPermissionTo('category.update') && $user->id === $category->user_id;

        

    }
    public function delete(User $user , Category $category): bool
    {
         if ($user->role === 'admin') {
            return true;
         }
        return Gate::authorize('category.delete') && $user->id === $category->user_id;
    }
}
