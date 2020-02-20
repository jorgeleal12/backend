<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model {
    protected $table    = 'contract_user';

    protected $fillable = [
        'idcontract_user',  'idcontract', 'users_idusers',
    ];

    public function user() {
        return $this->hasMany( User::class, 'idusers', 'users_idusers' );
    }
}
