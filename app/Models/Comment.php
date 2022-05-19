<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'driver_id',
        'recipient_id'
    ];

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function recipient() {
        return $this->belongsTo(Recipient::class);
    }
}
