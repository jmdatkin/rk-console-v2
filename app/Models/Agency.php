<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Agency extends Model implements Auditable {
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'notes'
    ];

    public function recipients() {
        return $this->hasMany(Recipient::class);
    }
}
