<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caseform_reliefs extends Model
{
    use HasFactory;

    protected $fillable = [
       'damage_from_disaster',
       'furniture_essitional',
       'clothes_for_all_season',
       'clothes_for_work_school',
       'enough_amount_of_food_daily',
       'help_from_organization',
       'suffer_psycologic_problem',
       'problem_food_plenty_family',
   ];
}
