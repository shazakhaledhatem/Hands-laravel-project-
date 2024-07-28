<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
     'full_name',
     'mother_name',
     'birth_place',
     'birth_date',
     'national_number',
     'gender',
     'marital_status',
     'phone_number',
     'address',
     'nationality',
     'mandatory_service',
     'email',
     'facebook',
     'instagram',
     'whatsapp',
     'education',
     'specilization',
     'number_of_years',
     'education_rate',
     'language_proficiency',
     'work_experiences',
     'training_courses',
     'other_volunteering',
     'hobbies',
     'ambition',
     'strengths',
     'weaknesses',
     'motivation_for_volunteering',
     'why_charity',
     'availability_for_volunteering',
     'preferred_time',
     'previous_experience',
     'Developmental',
     'Child_care',
     'Training',
     'Shelter_and_relief',
     'Events_and_conferences',
     'Awareness_campaigns',
     'Elderly_care',
     'Supporting_women',
     'Maintenance_technician',
     'field_media_photography',
     'Administrative_field',
     'charities_id',
     'status',
     'users_id'
 ];
 public function charity()
   {
       return $this->belongsTo(Charity::class, 'charities_id');
   }

   public function charityVolunteerEffectivenesses()
{
    return $this->hasMany(JoinEffectiveness::class, 'volenteer_id');
}

public function assignOrders()
    {
        return $this->hasMany(assign_orders_volunteer::class, 'volunteers_id');
    }
}
