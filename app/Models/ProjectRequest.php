<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'phone',
        'email',
        'project_type',
        'location',
        'width',
    'height',
        'budget',
        'timeline',
        'requirements',
        'status',
    ];
}