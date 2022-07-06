<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website'
    ];

    public function spareparts()
    {
        return $this->hasMany(Spareparts::class, 'brand_id');
    }

    public function hardware()
    {
        return $this->hasMany(Hardware::class, 'brand_id');
    }

    public function type()
    {
        return $this->hasMany(Type::class, 'brand_id');
    }
}