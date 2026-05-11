<?php

namespace App\Policies;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\TournamentParticipant;

class TournamentPolicy
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
    public function view(User $user, Tournament $tournament): bool
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
    public function update(User $user, Tournament $tournament): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tournament $tournament): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tournament $tournament): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tournament $tournament): bool
    {
        return false;
    }

    
    public function join(User $user, Tournament $tournament): bool
    {
       
        if ($tournament->status !== 'registration-phase') {
            return false;
        }

        $alreadyJoined = TournamentParticipant::where('tournament_id', $tournament->id)
            ->where('user_id', $user->id)
            ->exists();

        return !$alreadyJoined;
    }

    public function start(User $user){
        return $user->role=='admin';
    }
}
