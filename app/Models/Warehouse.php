<?php

namespace App\Models;

use App\Exceptions\WarehouseException;
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

    /**
     * @param int $materialId
     * @return mixed
     * @throws WarehouseException
     */
    public function getMaterial(int $materialId)
    {
        $material = $this
            ->materials()
            ->where('material_id', $materialId)
            ->get();

        if ($material->count() > 0) {
            return $material->first();
        }

        throw new WarehouseException(
            'Матеріал не знайдений в складі'
        );
    }
}
