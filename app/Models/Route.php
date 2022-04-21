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

    public function drivers() {
        return $this->belongsToMany(Driver::class);
    }

}
