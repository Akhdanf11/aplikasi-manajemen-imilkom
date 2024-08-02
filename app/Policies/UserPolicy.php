<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']);
    }

    public function update(User $user, User $model)
    {
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum', 'Kepala Departemen', 'Sekretaris Departemen']);
    }

    public function delete(User $user, User $model)
    {
        return in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']);
    }
}
