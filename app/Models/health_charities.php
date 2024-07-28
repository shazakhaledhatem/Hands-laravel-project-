<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class health_charities extends Model
{
    use HasFactory;
      protected $fillable = [
        'charities_id',
        'healths_id',
      //  'description',
      ];
}
