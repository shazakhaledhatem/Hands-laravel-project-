<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharityTargetPeople extends Model
{
    use HasFactory;
    protected $fillable = [
       'charities_id',
       'target_people_id',
       'vision_of_charity',
       'charity_goals',
       'charity_message',



   ];

   public function targetPeople()
    {
        return $this->belongsTo(TargetPeople::class, 'target_people_id');
    }
}
