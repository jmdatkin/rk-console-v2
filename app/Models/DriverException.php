<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverException extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'date_start',
        'date_end',
        'notes'
    ];

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
