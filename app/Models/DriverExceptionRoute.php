<?php

namespace App\Models;

use App\Report\DriverReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Ramsey\Uuid\Exception\DateTimeException;

class DriverExceptionRoute extends Pivot
{
    //
    protected $fillable = [
        'sub_id',
        'route_id',
        'e_id',
        'date'
    ];

    public function exception() {
        return $this->belongsTo(DriverException::class, 'e_id');
    }

    public function substituteDriver() {
        return $this->belongsTo(Driver::class, 'sub_id');
    }

    // public function setDate(): Attribute {
    //     return Attribute::make(
    //         get: fn ($value) => Carbon::parse($value),
    //         set: function ($value) {
    //             if (!$this->exception()->contains($value))
    //                 throw new DateTimeException("Date is out of range of exception");
    //             else
    //                 return $value;
    //         }
    //     );
    // }
}
