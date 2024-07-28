<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmeregencyStatus extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'active'];

  public function factors()
  {
      return $this->hasMany(Factrsofemergencystatus::class, 'emergencystatus_id');
  }

}
