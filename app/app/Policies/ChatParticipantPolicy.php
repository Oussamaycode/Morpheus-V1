<?php

namespace App\Policies;

use App\Models\User;
use App\Models\chatParticipant;
use Illuminate\Auth\Access\Response;

class ChatParticipantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, chatParticipant $chatParticipant): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, chatParticipant $chatParticipant): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, chatParticipant $chatParticipant): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, chatParticipant $chatParticipant): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, chatParticipant $chatParticipant): bool
    {
        return false;
    }
}
