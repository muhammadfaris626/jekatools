<?php

namespace App\Policies;

use App\Models\AccountItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('akun-product: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AccountItem $accountItem): bool
    {
        return $user->hasPermissionTo('akun-product: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('akun-product: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AccountItem $accountItem): bool
    {
        return $user->hasPermissionTo('akun-product: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AccountItem $accountItem): bool
    {
        return $user->hasPermissionTo('akun-product: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AccountItem $accountItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AccountItem $accountItem): bool
    {
        return false;
    }
}
