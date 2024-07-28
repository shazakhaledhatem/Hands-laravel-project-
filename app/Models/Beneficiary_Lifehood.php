<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Life_hood;
class Beneficiary_Lifehood extends Model
{
    use HasFactory;
    protected $fillable = [
       'beneficiaries_id',
       'lifehoods_id',
       'charities_id',
       'status',
       'active'
   ];
   public function lifehood()
   {
       return $this->belongsTo(Life_hood::class, 'lifehoods_id');
   }

   // Define relationship to Beneficiary
   public function beneficiary()
   {
       return $this->belongsTo(Beneficiary::class, 'beneficiaries_id');
   }

   public function life_hoods()
   {
       return $this->hasOne(Life_hood::class,'id');
   }

   public function ordersThatTransformedFromLifehoods()
    {
        return $this->hasMany(Ordersthattransoformedfromlifehoods::class, 'beneflifehoods_id');
    }
}
