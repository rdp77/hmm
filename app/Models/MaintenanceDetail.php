<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
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

    public function maintenance()
    {
        return $this->hasOne(Maintenance::class, 'mt_id');
    }
}