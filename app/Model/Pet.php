<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Pet extends Model
{
    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function getAge()
    {
        $years = Carbon::parse($this->birthday)->age;
        if ($years == 0) {
            $age = Carbon::createFromDate($this->birthday)->diff(Carbon::now())->format('%m months');
        } else {
            $age = Carbon::createFromDate($this->birthday)->diff(Carbon::now())->format('%y years and %m months');
        }
        return $age;
    }
}
