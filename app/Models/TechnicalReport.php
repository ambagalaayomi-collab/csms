<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalReport extends Model
{
    // 💡 ඩේටාබේස් ටේබල් එකේ නම හඳුන්වා දීම
    protected $table = 'technical_reports';

    // 💡 Default 'id' එක වෙනුවට 'report_id' Primary Key එක ලෙස හඳුන්වා දීම
    protected $primaryKey = 'report_id'; 

    // 💡 Mass Assignment එකෙන් දත්ත ආරක්ෂා කර ගැනීමට Columns හඳුන්වා දීම
    protected $fillable = [
        'req_id',
        'measurement_details',
        'total_budget',
        'duration',
        'date'
    ];
}