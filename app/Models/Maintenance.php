<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'maintenance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mtbf_id',
        'mttr_id',
        'hardware_id',
        'mt_id',
        'availability',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function detail()
    {
        return $this->belongsTo(MaintenanceDetail::class, 'mt_id');
    }

    public function mtbf()
    {
        return $this->belongsTo(MTBF::class, 'mtbf_id');
    }

    public function mttr()
    {
        return $this->belongsTo(MTTR::class, 'mttr_id');
    }

    public function dependency()
    {
        return $this->hasMany(Dependency::class, 'parent_mt_id');
    }

    public function hardware()
    {
        return $this->belongsTo(Hardware::class, 'hardware_id');
    }

    public function hasMTBF()
    {
        return $this->mtbf();
    }

    /**
     * Determine if the given relation is loaded.
     *
     * @param  string  $key
     * @return bool
     */
    public function relationLoaded($key)
    {
        return array_key_exists($key, $this->relations);
    }
}