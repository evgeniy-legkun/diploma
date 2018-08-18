<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';

    protected $fillable = ['name', 'address', 'note'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materials()
    {
        return $this->belongsToMany(
            Material::class,
            'warehouse_materials',
            'warehouse_id',
            'material_id'
        )->withPivot('quantity');
    }
}
