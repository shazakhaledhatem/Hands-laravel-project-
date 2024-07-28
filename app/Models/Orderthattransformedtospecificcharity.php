<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderthattransformedtospecificcharity extends Model
{
    use HasFactory;
    protected $fillable = [
    'charities_id',
    'charitythatrecieveorder_id',
    'reasonoftransformed',
];


public function charity()
{
    return $this->belongsTo(Charity::class, 'charities_id');
}


public function charityReceiver()
{
    return $this->belongsTo(Charity::class, 'charitythatrecieveorder_id');
}





}
