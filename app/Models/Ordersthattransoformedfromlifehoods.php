<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordersthattransoformedfromlifehoods extends Model
{
    use HasFactory;
    protected $fillable = [
      'charities_id',
      'beneflifehoods_id',
      'reasonoftransformed',
  ];


  public function charity()
  {
      return $this->belongsTo(Charity::class, 'charities_id');
  }


  public function beneficiaryLifehood()
  {
      return $this->belongsTo(Beneficiary_Lifehood::class, 'beneflifehoods_id');
  }
}
