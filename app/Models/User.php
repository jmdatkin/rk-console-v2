<?php

namespace App\Models;

use Error;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person_id',
        'name',
        'email',
        'password',
    ];

    protected $appends = [
        'email',
        'firstName',
        'lastName'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The associated Person model
     */
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Return true if the associated Person belongs to the specified Role
     * Use one of the Role constants defined in the model class
     * 
     * @param string $role
     * @return boolean
     */
    public function hasRole($role) {
       return $this->person->hasRole($role); 
    }
    
    public function getEmailAttribute()
    {
        return optional($this->person)->getAttribute('email');
    }

    public function getFirstNameAttribute()
    {
        return optional($this->person)->getAttribute('firstName');
    }

    public function getLastNameAttribute()
    {
        return optional($this->person)->getAttribute('lastName');
    }

}
