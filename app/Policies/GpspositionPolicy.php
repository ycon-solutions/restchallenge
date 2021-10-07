<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Gpsposition;
use Illuminate\Auth\Access\HandlesAuthorization;

class GpspositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the gpsposition can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list gpspositions');
    }

    /**
     * Determine whether the gpsposition can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Gpsposition  $model
     * @return mixed
     */
    public function view(User $user, Gpsposition $model)
    {
        return $user->hasPermissionTo('view gpspositions');
    }

    /**
     * Determine whether the gpsposition can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create gpspositions');
    }

    /**
     * Determine whether the gpsposition can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Gpsposition  $model
     * @return mixed
     */
    public function update(User $user, Gpsposition $model)
    {
        return $user->hasPermissionTo('update gpspositions');
    }

    /**
     * Determine whether the gpsposition can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Gpsposition  $model
     * @return mixed
     */
    public function delete(User $user, Gpsposition $model)
    {
        return $user->hasPermissionTo('delete gpspositions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Gpsposition  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete gpspositions');
    }

    /**
     * Determine whether the gpsposition can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Gpsposition  $model
     * @return mixed
     */
    public function restore(User $user, Gpsposition $model)
    {
        return false;
    }

    /**
     * Determine whether the gpsposition can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Gpsposition  $model
     * @return mixed
     */
    public function forceDelete(User $user, Gpsposition $model)
    {
        return false;
    }
}
