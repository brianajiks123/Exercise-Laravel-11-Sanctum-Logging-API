<?php

namespace App\Policies;

use App\Models\Todolist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TodolistPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Todolist $todolist): Response
    {
        return $user->id === $todolist->user_id
            ? Response::allow()
            : Response::deny("You do not own this todo, can not view.");
    }

    /**
     * Determine whether the user can create m odels.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Todolist $todolist): Response
    {
        return $user->id === $todolist->user_id
            ? Response::allow()
            : Response::deny("You do not own this todo, can not update.");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todolist $todolist): Response
    {
        return $user->id === $todolist->user_id
            ? Response::allow()
            : Response::deny("You do not own this todo, can not delete.");
    }
}
