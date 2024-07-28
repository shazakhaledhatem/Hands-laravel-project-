<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Effectivenessreports extends Model
{
    use HasFactory;

    protected $fillable = [
  'charities_id',
  'effectivenesses_id',
  'date',
  'description',
  'final_budget',
];
}
