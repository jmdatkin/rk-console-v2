<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
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

    public function person() {
        return $this->belongsTo(Person::class);
    }

    //Many-to-many linkage between route
    public function routes()
    {
        return $this->belongsToMany(Route::class);
    }

    public function assignRoute($route_id)
    {
        try {
            $this->routes()->attach($route_id);
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function deassignRoute($route_id)
    {
        try {
            $this->routes()->deatch($route_id);
        } catch (Exception $e) {
            error_log($e);
        }
    }
}
