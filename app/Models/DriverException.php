<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

// class DriverException extends Model
class DriverException extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'substitute_driver_id',
        'date_start',
        'date_end',
        'notes'
    ];

    protected $with = ['driver', 'substituteDriver'];
    
    protected $appends = ['length'];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime'
    ];

    public function driver() {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function substituteDriver() {
        return $this->belongsTo(Driver::class, 'substitute_driver_id');
    }

    public function getLengthAttribute() {
        // Number of days between dates
        return $this->date_start->diff($this->date_end)->days;
    }

    // public function setSubstituteDriver() {
    //         $this->substituteDriver()->associate()
    // }

    public function contains($date) {
        return Carbon::parse($date)->between($this->date_start,$this->date_end);
    }

    protected function setDateStartAttribute($value) {
        $this->attributes['date_start'] = Carbon::parse($value);
    }

    protected function setDateEndAttribute($value) {
        $this->attributes['date_end'] = Carbon::parse($value);
    }
}
