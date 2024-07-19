<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'role', 
        'user_image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUserImageAttribute($value)
    {
        return $value ? 'user_image/' . $value : 'default/employee.png';
    }
    protected $table = 'users';
}