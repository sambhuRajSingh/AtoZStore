<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Timestamp not used.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define date in UK format.
     *
     * @var bool
     */
    protected $dateFormat = 'd.m.Y';

    /**
     * A particular transaction belong to a store.
     */
    public function Store()
    {
        return $this->belongsTo('App\Store');
    }
}
