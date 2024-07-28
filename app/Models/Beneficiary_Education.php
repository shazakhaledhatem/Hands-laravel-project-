<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Education;
class Beneficiary_Education extends Model
{
    use HasFactory;
    protected $fillable = ['beneficiaries_id', 'education_id', 'charities_id', 'active', 'status'];



    public function education()
    {
        return $this->hasOne(Education::class,'id');
    }

    public function ordersthattransoformedfromeducations()
     {
         return $this->hasMany(Ordersthattransoformedfromeducations::class, 'beneficiaries__educations_id');
     }
}
