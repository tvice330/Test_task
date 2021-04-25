<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Client extends Model
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'full_name', 'email', 'phone', 'birthday', 'address', 'note', 'password'
    ];

    protected $hidden = ['password'];
}
