<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'phoneHome',
        'phoneCell',
        'notes'
    ];

    //Many-to-many linkage between route
    public function routes() {
        return $this->belongsToMany(Route::class);
    }

    public function setRoute($route_id) {
        $this->routes()->detach();              //Remove existing assignments
        $this->routes()->attach($route_id);     //Set new route id
    }
}