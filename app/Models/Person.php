<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
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

    public function driver() {
        return $this->hasOne(Driver::class);
    }

    public function recipient() {
        return $this->hasOne(Recipient::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
}
