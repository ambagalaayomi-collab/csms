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
    // app/Models/ProjectRequest.php

public function technicalReport()
{
    
    
     return $this->hasOne(TechnicalReport::class, 'req_id', 'id')
        ->latestOfMany('report_id');
}

public function estimate()
{
    return $this->hasOne(Estimate::class, 'project_request_id'); 
     return $this->hasOne(Estimate::class);

}


    
}
