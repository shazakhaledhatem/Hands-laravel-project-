<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetPeople extends Model
{
    use HasFactory;
    protected $fillable = [
       'age',
       'babies',
       'female',
       'male',
       'elderly',
       'youth',
       'childern',

   ];

   public function charityTargetPeople()
   {
       return $this->hasMany(CharityTargetPeople::class, 'target_people_id');
   }
}
