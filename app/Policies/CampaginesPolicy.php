<?php

namespace App\Policies;

use App\Models\Campagines;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaginesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $user->hasAbility('view-campagines',Campagines::class);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Campagines $campagines)
    {
        $user->hasAbility('view-campagines',$campagines);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $user->hasAbility('create-campagines',Campagines::class);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Campagines $campagines)
    {
        $user->hasAbility('update-campagines',$campagines);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Campagines $campagines)
    {
        $user->hasAbility('delete-campagines',$campagines);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Campagines $campagines)
    {
        $user->hasAbility('restore-campagines',$campagines);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Campagines $campagines)
    {
        $user->hasAbility('force-delete-campagines',$campagines);
    }
}
