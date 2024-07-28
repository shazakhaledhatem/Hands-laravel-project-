<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordersthattransoformedfromeducations extends Model
{
    use HasFactory;

    protected $fillable = [
      'charities_id',
      'beneficiaries__educations_id',
      'reasonoftransformed',
  ];


  public function charity()
  {
      return $this->belongsTo(Charity::class, 'charities_id');
  }


  public function beneficiaryeducation()
  {
      return $this->belongsTo(Beneficiary_Education::class, 'beneficiaries__educations_id');
  }
}
