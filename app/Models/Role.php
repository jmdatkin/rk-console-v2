<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    public const ADMIN  = 'admin';
    public const DRIVER = 'driver';
    public const RECIPIENT = 'recipient';

    public function people() {
        return $this->belongsToMany(Person::class);
    }


}
