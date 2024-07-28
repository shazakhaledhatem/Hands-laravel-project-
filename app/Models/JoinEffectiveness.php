<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinEffectiveness extends Model
{
    use HasFactory;
    protected $fillable = [
        'charities_id',
        'volenteer_id',
        'effectiveness_id',
        'status'
    ];

    public function charity()
    {
        return $this->belongsTo(Charity::class, 'charities_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volenteer_id');
    }

    public function effectiveness()
    {
        return $this->belongsTo(Effectiveness::class, 'effectiveness_id');
    }
}
