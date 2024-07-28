<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caseform_health extends Model
{
    use HasFactory;

    protected $fillable = [
       'insourance',
       'type_ins',
       'main_pro',
       'suffer_time',
       'inh_history',
       'inh_history_name',
       'surgery',
       'surgery_name',
       'symptom',
       'symptom_time',
       'time_cond',
       'daily_effect',
       'pirman_medicine',
       'priman_name',

   ];

}
