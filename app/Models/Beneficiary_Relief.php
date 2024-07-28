<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relief;

class Beneficiary_Relief extends Model
{
    use HasFactory;
    //protected $table = 'beneficiaries__reliefs';

   protected $fillable = ['beneficiaries_id', 'reliefs_id', 'charities_id', 'active', 'status'];


   public function relief()
   {
       return $this->hasOne(Relief::class,'id');
   }

   public function ordersthattransoformedfromreliefs()
    {
        return $this->hasMany(Ordersthattransoformedfromreliefs::class, 'beneficiaries__reliefs_id');
    }
}
