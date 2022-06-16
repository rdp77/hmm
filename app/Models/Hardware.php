<?php

namespace App\Models;

use App\Enums\HardwareStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hardware extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hardware';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'serial_number',
        'name',
        'description',
        'model',
        'brand_id',
        'status',
        'purchase_date',
        'warranty_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => HardwareStatusEnum::class
    ];

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
}