<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Health;
class Beneficiary_Health extends Model
{
    use HasFactory;
    protected $fillable = [
       'beneficiaries_id',
       'healths_id',
       'charities_id',
       'status',
       'active'
   ];
   public function healths()
   {
       return $this->hasOne(Health::class,'id');
   }

   public function ordersthattransoformedfromhealths()
    {
        return $this->hasMany(ordersthattransoformedfromhealth::class, 'beneficiaries__healths_id');
    }
}
