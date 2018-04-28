<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * Timestamp not used.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'address', 'postcode'];

    /**
     * A particular store can have many transactions.
     */
    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
}
