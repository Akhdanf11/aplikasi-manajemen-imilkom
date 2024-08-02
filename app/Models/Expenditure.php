<?php

// app/Models/Expenditure.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = ['item', 'amount', 'status', 'proof_image', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ][$this->status];
    }
}
