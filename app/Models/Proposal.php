<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'project_request_id',
        'client_id',
        'manager_id',
        'proposal_details',
        'total_budget',
        'estimated_duration',
        'status',
        'response_comment',
        'pdf_path',
    ];
}