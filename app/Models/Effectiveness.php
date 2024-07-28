<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Effectiveness extends Model
{
    use HasFactory;
    protected $fillable = [
       'image',
       'name',
       'type_of_effectiveness',
       'initial_budget',
       'final_budget',
       'start_date',
       'end_date',
       'description',
       'location_that_covered_by_charities_id',
       'charities_id',
       'numberofvolunteer',
       'numberofparicipations',

   ];
   public function locationThatCoveredByCharities()
   {
       return $this->belongsTo(LocationThatCoveredByCharities::class);
   }

   public function charity()
    {
        return $this->belongsTo(Charity::class);
    }
   public function location()
{
    return $this->belongsTo(LocationThatCoveredByCharities::class, 'location_that_covered_by_charities_id');
}

public function charityVolunteerEffectivenesses()
{
    return $this->hasMany(JoinEffectiveness::class, 'effectiveness_id');
}
}
