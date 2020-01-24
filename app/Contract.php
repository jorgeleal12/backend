<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table    = 'contract_user';
    protected $fillable = [
        'idcontract_user', 'users_idusers', 'idcontract',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'idusers', 'users_idusers');
    }
}
