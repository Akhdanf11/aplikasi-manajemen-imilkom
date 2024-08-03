<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Inventory;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any inventories.
     */
    public function viewAny(User $user)
    {
        // Allow access to BPH members, Department Heads, and Department Secretaries
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum', 'Kepala Departemen', 'Sekretaris Departemen']);
    }

    /**
     * Determine whether the user can view the inventory.
     */
    public function view(User $user, Inventory $inventory)
    {
        // Allow access to BPH members, Department Heads, and Department Secretaries
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum', 'Kepala Departemen', 'Sekretaris Departemen']);
    }

    /**
     * Determine whether the user can create inventories.
     */
    public function create(User $user)
    {
        // Allow access to BPH members and Department Heads
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum', 'Kepala Departemen']);
    }

    /**
     * Determine whether the user can update the inventory.
     */
    public function update(User $user, Inventory $inventory)
    {
        // Allow access to BPH members and Department Heads
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum', 'Kepala Departemen']);
    }

    /**
     * Determine whether the user can delete the inventory.
     */
    public function delete(User $user, Inventory $inventory)
    {
        // Allow access to BPH members
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']);
    }
}
