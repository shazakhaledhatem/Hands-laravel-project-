<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
  'charities_id',
  'name',
  'phone',
  'image',
  'amount',
  'number_bill',
  'userid',

];

public function financialReports()
  {
      return $this->hasMany(Finiancialreports::class, 'donation_id', 'id');
  }
}
