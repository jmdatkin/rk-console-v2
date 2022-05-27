<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes'
    ];

    public function recipients() {
        return $this->belongsToMany(Recipient::class);
    }

    public function recipientsOnDay($weekday) {
        return $this->belongsToMany(Recipient::class)->wherePivot('weekday', $weekday);
    }

    public function drivers() {
        return $this->belongsToMany(Driver::class);
    }

    public function driversOnDay($weekday) {
        return $this->belongsToMany(Driver::class)->wherePivot('weekday', $weekday);
    }

    public function driverAlternates() {
        return $this->belongsToMany(Driver::class, 'driver_route_alt');
    }

}
