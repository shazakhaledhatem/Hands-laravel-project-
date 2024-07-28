<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assign_orders_volunteer extends Model
{
    use HasFactory;
    protected $fillable = ['beneficiaries_id', 'charities_id', 'volunteers_id', 'discription'];


    public function beneficiary()
        {
            return $this->belongsTo(Beneficiary::class, 'beneficiaries_id');
        }
}
