<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
         'project_request_id',
    'technical_report_id',
    'client_id',
    'manager_id',
    'proposal_details',
    'total_budget',
    'estimated_duration',
    'status',
    'response_comment',
    'pdf_path',
    ];

    public function technicalReport()
    {
        return $this->belongsTo(
            TechnicalReport::class,
            'technical_report_id'
        );
    }

    public function projectRequest()
    {
        return $this->belongsTo(
            ProjectRequest::class,
            'project_request_id'
        );
    }
}