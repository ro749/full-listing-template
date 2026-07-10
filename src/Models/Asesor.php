<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Authenticable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
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

    public function clients(): HasMany {
        return $this->hasMany(Client::get_class());
    }

    public function quotations(): HasMany{
        return $this->hasMany(Quotation::get_class());
    }

    public function get_default_model(){
        return [
                'name' => 'test',
                'category' => '0',
                'mail' => 'test@example.com',
                'phone' => '3337811700',
                'number' => '1111',
                'password' => Hash::make('1111')
            ];
    }
}
