<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factrsofemergencystatus extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'emergencystatus_id'];

  public function emergencyStatus()
  {
      return $this->belongsTo(EmergencyStatus::class, 'emergencystatus_id');
  }
}
