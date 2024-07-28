<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caseform_education_mid extends Model
{
    use HasFactory;

    protected $fillable = [
       'caseforms_id',
       'caseformeducations_id',
       'assign_id',
       'date',


   ];


   public function assignOrdersVolunteer()
{
    return $this->belongsTo(assign_orders_volunteer::class, 'assign_id');
}

public function caseformEducation()
{
    return $this->belongsTo(caseform_education::class, 'caseformeducations_id');
}

}
