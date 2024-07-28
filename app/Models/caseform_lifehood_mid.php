<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caseform_lifehood_mid extends Model
{
    use HasFactory;



    protected $fillable = [
       'caseforms_id',
       'caseformlifehoods_id',
       'assign_id',
       'date',


   ];

   public function assignOrdersVolunteer()
{
    return $this->belongsTo(assign_orders_volunteer::class, 'assign_id');
}

public function caseformLifehood()
{
    return $this->belongsTo(caseform_lifehoods::class, 'caseformlifehoods_id');
}

}
