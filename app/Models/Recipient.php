<?php

namespace App\Models;

use App\Events\LogModelChanges;
use App\Events\RecipientModelUpdated;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Recipient extends BasePersonRole
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'numMeals',
        'address'
    ];

    protected $with = ['person', 'agency'];

    protected $touches = ['person'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    //Many-to-many linkage between route
    public function routes()
    {
        return $this->belongsToMany(Route::class)->withPivot(['weekday']);
    }

    /**
     * Sets a recipient's assigned route for the given weekday
     * 
     * @param route_id
     * @param weekday
     */
    public function setRoute($route_id, $weekday)
    {
            $this->routes()->wherePivot('weekday', $weekday)->detach();
            $this->routes()->attach($route_id, ['weekday' => $weekday]);     //Set new route id
    }
}
