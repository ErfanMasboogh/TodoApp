<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    public function update(User $user, Category $category): bool
    {
        if ($user->id == $category->user_id) {
            return true;
        }
        return false;
    }
    public function delete(User $user, Category $category): bool
    {
        if ($user->id == $category->user_id) {
            return true;
        }
        return false;
    }
}
