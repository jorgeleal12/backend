<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table    = 'contract_user';
    protected $fillable = [
        'idcontract_user', 'users_idusers', 'idcontract',
    ];
}
