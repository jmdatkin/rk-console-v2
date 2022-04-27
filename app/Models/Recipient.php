<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'numMeals'
    ];

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function agency() {
        return $this->belongsTo(Agency::class);
    }

    //Many-to-many linkage between route
    public function routes() {
        return $this->belongsToMany(Route::class);
    }

    public function setRoute($route_id, $weekday) {
        // $this->routes()->detach();              //Remove existing assignments
        $this->routes()->attach($route_id, [ 'day' => $weekday]);     //Set new route id
    }
}