<?php

// app/Models/Income.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
