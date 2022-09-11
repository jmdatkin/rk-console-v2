<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public function getValueAttribute($value) {
        switch ($value) {
            case 'boolean':
                return (bool)$value;
            case 'string':
                return $value;
            default:
                return $value;
        }
    }

    public function scopeRetrieve($query, $key) {
        
    }
}
