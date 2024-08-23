<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {

        return $this->hasSuperadminRole($user) ||
            $this->hasHodRoleInItuDepartment($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // if ($user->hasRole('superadmin') || ($user->hasRole('hod') &&$user->belongsToDepartmentOf('IT Unit'))){
        //     return true;
        // }
        // else{
        //     return false;
        // }
        return $this->hasSuperadminRole($user) ||
            $this->hasHodRoleInItuDepartment($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id != $model->id && ($user->belongsToDepartmentOf('IT Unit')|| $user->hasRole('hod'));
    }

    public function activate(User $user)
    {
        return $user->must_reset == true;
    }

    public function updateSelf(User $model, User $user)
    {
        return $user->id != $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }

    private function hasSuperadminRole($user)
    {
        return $user->roles()->where('name', 'superadmin')->exists();
    }

    private function hasHodRoleInItuDepartment($user)
    {
        return $user->roles->contains('name', 'hod') &&
                $user->staff->whereHas('department', function($q) {
                $q->where('name', 'ITU');
                })->exists();
    }
}
