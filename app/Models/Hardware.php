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
        'type_id',
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

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'hardware_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}