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
    public function estimate()
    {
        return $this->hasOne(Estimate::class, 'project_request_id'); 
    }

    // 2. Technical Reports table එකත් එක්ක රිලේෂන් එක (foreign key එක 'req_id' බව මෙහිදී කියයි)
    public function technicalReport()
    {
        return $this->hasOne(TechnicalReport::class, 'req_id');
    }
}
