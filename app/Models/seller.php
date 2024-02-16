<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class seller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='seller';
    protected $guard='seller';
    protected $fillable = [
        'Email',
        'Name',
        'MobileNo',
        'CNIC',
        'Password'
    ];
    protected $hidden = [
        'Password',
    ];
}
