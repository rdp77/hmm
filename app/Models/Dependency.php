<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dependency extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dependency';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mt_id',
        'parent_mt_id'
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'parent_mt_id');
    }
}