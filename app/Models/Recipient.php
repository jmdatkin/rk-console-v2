<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends BasePersonRole
{
    use HasFactory;

    protected $fillable = [
        'numMeals',
        'address'
    ];

    protected $with = ['person','agency'];

    protected $touches = ['person'];

    // public function __construct() {
    //     $this->with = array_merge(['agency'], parent::$this->with);
    // }

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function agency() {
        return $this->belongsTo(Agency::class);
    }

    //Many-to-many linkage between route
    public function routes() {
        return $this->belongsToMany(Route::class)->withPivot(['weekday']);
    }

    public function setRoute($route_id, $weekday) {
        $this->routes()->attach($route_id, [ 'weekday' => $weekday]);     //Set new route id
    }
}