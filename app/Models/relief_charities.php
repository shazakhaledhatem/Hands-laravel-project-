<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relief_charities extends Model
{
    use HasFactory;
    protected $fillable = [
      'charities_id',
      'reliefs_id',
      //'description',
    ];
}
