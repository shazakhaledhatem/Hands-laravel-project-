<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderesfromemergencystatus extends Model
{
    use HasFactory;
    protected $fillable = ['charities_id', 'description', 'first_name', 'last_name','phone','gender','birthday','address','needs','status','user_id'];


    protected $casts = [
            'needs' => 'array',
                'birthday' => 'date'

        ];
        public function charity()
           {
               return $this->belongsTo(Charity::class, 'charities_id');
           }
}
