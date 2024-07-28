<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordersthattransoformedfromreliefs extends Model
{
    use HasFactory;
    protected $fillable = [
      'charities_id',
      'beneficiaries__reliefs_id',
      'reasonoftransformed',
  ];


  public function charity()
  {
      return $this->belongsTo(Charity::class, 'charities_id');
  }


  public function beneficiaryrelief()
  {
      return $this->belongsTo(Beneficiary_Relief::class, 'beneficiaries__reliefs_id');
  }
}
