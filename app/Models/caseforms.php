<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caseforms extends Model
{
    use HasFactory;

    protected $fillable = [
       'main_res',
       'main_res_des',
       'add_res',
       'add_res_des',
       'diff_cover_monthly_exp',
       'loans',
       'value_loans',
       'rent_own',
       'type_of_res',
       'rent_value',
       'desc',
   ];


   public function caseformHealthMids()
{
    return $this->hasMany(caseform_health_mid::class, 'caseforms_id');
}

public function caseformEducationMids()
{
    return $this->hasMany(caseform_education_mid::class, 'caseforms_id');
}

public function caseformReliefMids()
{
    return $this->hasMany(caseform_relief_mid::class, 'caseforms_id');
}

public function caseformLifehoodMids()
{
    return $this->hasMany(caseform_lifehood_mid::class, 'caseforms_id');
}

}
