<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Role;

class Person extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
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
        return $this->hasOne(User::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role) {
        $this->roles()->attach(
            Role::where('name',$role)->first()
        );
    }

    /**
     * Returns true if the Person has the specified Role
     * Use one of the constants defined in the Role model class
     * 
     * @param string $role
     * @return boolean
     */
    public function hasRole($role) {
        $role_obj = Role::where('name',$role)->first();
        return $this->roles->contains($role_obj);
    }
}
