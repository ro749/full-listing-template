<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Authenticable;
class Asesor extends Authenticable
{
    protected $fillable = [
        'number',
        'password',
        'phone',
        'mail',
        'name',
        'category',
        'pfp',
        'status',
        'reset',
        'last_session_register'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
