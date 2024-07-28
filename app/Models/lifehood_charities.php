<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lifehood_charities extends Model
{
    use HasFactory;
    protected $fillable = [
      'charities_id',
      'life_hoods_id',
    //  'description',
    ];
}
