<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Model;   // driver MongoDB

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    MustVerifyEmail
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmailTrait,
        HasFactory,
        Notifiable;

    /* nama collection di MongoDB Atlas */
    protected $collection = 'users';

    /* field yang boleh mass-assignment */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /* field yang disembunyikan saat serialize/array/json */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* cast tipe data */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}