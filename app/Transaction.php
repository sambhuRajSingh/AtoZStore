<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['store_id', 'transaction_id', 'total_amount', 'currency', 'created_at'];

    /**
     * A particular transaction belong to a store.
     */
    public function Store()
    {
        return $this->belongsTo('App\Store');
    }

    public function setCreatedAtAttribute($date)
    {
        $this->attributes['created_at'] = Carbon::parse($date);
    }
}
