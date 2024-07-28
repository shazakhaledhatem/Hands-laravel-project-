<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationThatCoveredByCharities extends Model
{
    use HasFactory;
    protected $fillable = [
       'governorate',
       'district',
       'sub_district',
       'community',
       'street',
       'charities_id',
   ];
   public function charity()
       {
           return $this->belongsTo('App\Models\Charity', 'charities_id');
       }
}
