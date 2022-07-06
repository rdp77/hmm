<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codename',
        'name',
        'brand_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }

    public function hardware()
    {
        return $this->hasMany(Hardware::class, 'type_id');
    }
}