<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

class TodoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Todo $todo): bool
    {
        if ($user->id == $todo->user_id) {
            return true;
        }
        return false;
    }
    public function delete(User $user, Todo $todo): bool
    {
        if ($user->id == $todo->user_id) {
            return true;
        }
        return false;
    }
}
