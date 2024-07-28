<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caseform_lifehoods extends Model
{
    use HasFactory;


    protected $fillable = [
       'profession_learn',
       'reason_profession',
       'finanical_scholar_support',
       'major',
       'year_in_work',
       'knowlodege_you_earn',
       'your_previous_work',
       'looking_for_job',
       'type_looking_for_job',
       'apply_job',
       'number_request',
       'job_offer',
       'what_kind',
   ];
}
