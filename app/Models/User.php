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

    // protected $with = [
    //     'person'
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function person()
    {
        // return $this->hasOne(Person::class);
        return $this->belongsTo(Person::class, 'person_id');
        // return $this->belongsTo('App\Models\Person', 'person_id');
    }

    public function getEmailAttribute()
    {
        // dd($this->person()->get(['email']));
        return optional($this->person)->getAttribute('email');
        // return $this->person()->get(['email']);
        // This is terrible
        // return Person::where('id',$this->person_id)->first()->email;
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
