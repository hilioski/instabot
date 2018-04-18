<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule_id',
        'email',
        'password',
        'instagram_user_id',
        'instagram_access_token',
        'instagram_username',
        'instagram_profile_picture',
        'instagram_full_name',
        'instagram_bio',
        'instagram_website',
        'instagram_is_business',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Hash the password given
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // Relations
    public function rule(){
        return $this->belongsTo(Rule::class);
    }
}
