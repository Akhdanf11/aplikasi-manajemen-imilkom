<?php

// app/Policies/ProjectPolicy.php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project)
    {
        return $user->role->name === 'Ketua Umum' || 
               $user->role->name === 'Sekretaris Umum' || 
               $user->role->name === 'Bendahara Umum' || 
               $user->department_id === $project->department_id ||
               $user->id === $project->user_id;
    }

    public function update(User $user, Project $project)
    {
        return $user->id === $project->user_id || $user->role->name === 'Ketua Umum';
    }

    public function delete(User $user, Project $project)
    {
        return $user->id === $project->user_id || $user->role->name === 'Ketua Umum';
    }
}

