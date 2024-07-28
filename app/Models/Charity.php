<?php

namespace App\Models;

//use Illuminate\Foundation\Auth\Charity as Authenticatable;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Charity extends Model
{

   use HasApiTokens, HasFactory, Notifiable;
  //  use HasApiTokens, HasFactory, Notifiable;
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
      'description',
     ];
     public function effectiveness()
        {
            return $this->hasOne(Effectiveness::class);
        }

     public function locations()
     {
         return $this->hasMany('App\Models\LocationThatCoveredByCharity', 'charities_id');
     }


     public function ordersThatTransformedFromLifehoods()
    {
        return $this->hasMany(Ordersthattransoformedfromlifehoods::class, 'charities_id');
    }

    public function ordersthattransoformedfromeducations()
   {
       return $this->hasMany(Ordersthattransoformedfromeducations::class, 'charities_id');
   }
   public function ordersthattransoformedfromhealths()
  {
      return $this->hasMany(ordersthattransoformedfromhealth::class, 'charities_id');
  }
  public function ordersthattransoformedfromreliefs()
 {
     return $this->hasMany(Ordersthattransoformedfromreliefs::class, 'charities_id');
 }


 public function sentOrders()
    {
        return $this->hasMany(Orderthattransformedtospecificcharity::class, 'charities_id');
    }

    /**
     * Get the orders that the charity received.
     */
    public function receivedOrders()
    {
        return $this->hasMany(Orderthattransformedtospecificcharity::class, 'charitythatrecieveorder_id');
    }

   public function charityVolunteerEffectivenesses()
{
    return $this->hasMany(JoinEffectiveness::class, 'charities_id');
}
     /**
      * The attributes that should be hidden for serialization.
      *
      * @var array<int, string>
      */
     protected $hidden = [
         'password',
         'remember_token',
     ];

     /**
      * The attributes that should be cast.
      *
      * @var array<string, string>
      */
     protected $casts = [
         'email_verified_at' => 'datetime',
               'image' => 'array' // Define casting to array here
     ];


}
