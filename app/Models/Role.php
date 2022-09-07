<?php

namespace App\Models;

use App\Traits\HasArchive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasArchive;

    public $timestamps = false;

    public const ADMIN  = 'admin';
    public const DRIVER = 'driver';
    public const RECIPIENT = 'recipient';

    public function people() {
        return $this->belongsToMany(Person::class);
    }

    public static function ADMIN() {
        return self::where('name', 'admin')->first();
    }

    public static function DRIVER() {
        return self::where('name', 'driver')->first();
    }

    public static function RECIPIENT() {
        return self::where('name', 'recipient')->first();
    }


}
