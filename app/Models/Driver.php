<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
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

    //Many-to-many linkage between route
    public function routes() {
        return $this->belongsToMany(Route::class);
    }
}
