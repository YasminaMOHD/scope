<?php

namespace App\Policies;

use App\Models\Agents;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgentsPolicy
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
        $user->hasAbility('view-agent',Agents::class);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Agents $agents)
    {
        $user->hasAbility('view-agent',$agents);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $user->hasAbility('create-agent',Agents::class);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Agents $agents)
    {
        $user->hasAbility('update-agent',$agents);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Agents $agents)
    {
        $user->hasAbility('delete-agent',$agents);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Agents $agents)
    {
        $user->hasAbility('restore-agent',$agents);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Agents $agents)
    {
        $user->hasAbility('force-delete-agent',$agents);
    }
}
