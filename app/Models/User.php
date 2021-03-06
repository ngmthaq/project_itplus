<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
        'facebook_id',
        'google_id',
        'github_id',
        'token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Table
    protected $table = 'users';

    // Has a user information
    public function userInformation()
    {
        return $this->hasOne(UserInformation::class, 'user_id');
    }

    // Has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    // Has many posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    // Belong to role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Hash Password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Ucfirst first name
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    // Ucfirst last name
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }
}
