<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintanceDetail extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mt_dt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];
}