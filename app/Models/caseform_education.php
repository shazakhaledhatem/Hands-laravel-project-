<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caseform_education extends Model
{
    use HasFactory;

    protected $fillable = [
       'class',
       'school_name',
       'number_of_year_delay',
       'reason_of_delay',
       'times_to_buy_clothes_during_year',
       'cost_of_tools_in_semester',
       'participate_in_courses',
       'participate_in_courses_name',
       'need_courses',
       'courses_name',
       'many_times_change_bages',
       'any_hopies',


   ];
}
