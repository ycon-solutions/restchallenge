<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shipment can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list shipments');
    }

    /**
     * Determine whether the shipment can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Shipment  $model
     * @return mixed
     */
    public function view(User $user, Shipment $model)
    {
        return $user->hasPermissionTo('view shipments');
    }

    /**
     * Determine whether the shipment can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create shipments');
    }

    /**
     * Determine whether the shipment can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Shipment  $model
     * @return mixed
     */
    public function update(User $user, Shipment $model)
    {
        return $user->hasPermissionTo('update shipments');
    }

    /**
     * Determine whether the shipment can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Shipment  $model
     * @return mixed
     */
    public function delete(User $user, Shipment $model)
    {
        return $user->hasPermissionTo('delete shipments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Shipment  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete shipments');
    }

    /**
     * Determine whether the shipment can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Shipment  $model
     * @return mixed
     */
    public function restore(User $user, Shipment $model)
    {
        return false;
    }

    /**
     * Determine whether the shipment can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Shipment  $model
     * @return mixed
     */
    public function forceDelete(User $user, Shipment $model)
    {
        return false;
    }
}
