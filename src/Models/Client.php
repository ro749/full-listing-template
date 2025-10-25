<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;
class Client extends Model
{
    protected $fillable = [
        'name',
        'mail',
        'phone',
        'asesor',
        'category',
        'priority',
        'short_comment',
        'long_comment',
    ];
}
