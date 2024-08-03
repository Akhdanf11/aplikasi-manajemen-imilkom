<?php

// app/Models/Project.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Income;
use App\Models\Attendance;
use App\Models\Expenditure;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'department_id', 'user_id'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function expenditures()
    {
        return $this->hasMany(Expenditure::class);
    }

    public function income()
    {
        return $this->hasMany(Income::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
