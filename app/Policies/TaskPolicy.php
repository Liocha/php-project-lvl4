<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Task $task)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Task $task)
    {
        return true;
    }

    public function delete(User $user, Task $task)
    {
        if ($task->created_by_id == $user->id) {
            return true;
        }
        return false;
    }
}
