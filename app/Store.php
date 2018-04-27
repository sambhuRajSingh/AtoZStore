<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * A particular store can have many transactions.
     */
    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
}
