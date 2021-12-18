<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    // public function getRouteKeyName()
    // {
    //     return 'name';
    // }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
    public function breed()
    {
        return $this->belongsTo('App\Breed');
    }




}
