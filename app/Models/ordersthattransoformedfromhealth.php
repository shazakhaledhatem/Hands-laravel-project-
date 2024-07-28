<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordersthattransoformedfromhealth extends Model
{
    use HasFactory;
    protected $fillable = [
      'charities_id',
      'beneficiaries__healths_id',
      'reasonoftransformed',
  ];


  public function charity()
  {
      return $this->belongsTo(Charity::class, 'charities_id');
  }


  public function beneficiaryhealth()
  {
      return $this->belongsTo(Beneficiary_Health::class, 'beneficiaries__healths_id');
  }
}
