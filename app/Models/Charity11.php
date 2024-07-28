<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Charity11 extends Model
{
    use HasFactory;
    use  HasApiTokens;
    protected $fillable = [
        'name',
      'email',
      'password',
      'address',
      'nameoftheheadofcharity',
      'vicepresidentofcharity',
      'typeofcharity',
      'nameofcashier',
      'numberbankaccount',
      'licensenumber',
      'numberofvolunteer',
      'linkwebsite',
      'charityphone',
      'whatsappnumber',
      'linkoffacebookpage',
      'image',
     ];
}
