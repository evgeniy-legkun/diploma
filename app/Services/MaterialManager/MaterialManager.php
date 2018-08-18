<?php

namespace App\Services\MaterialManager;

use App\Models\Material;

/**
 * Class MaterialManager
 * @package App\Services\MaterialManager
 */
class MaterialManager
{
    /**
     * @param string $name
     * @param int $unit
     * @return mixed
     */
    public function createMaterial(string $name, int $unit)
    {
        $material = Material::create([
            'name' => $name,
            'unit' => $unit
        ]);

        return $material;
    }

    /**
     * @param int $materialId
     * @param string $name
     * @param int $unit
     * @throws MaterialManagerException
     */
    public function updateMaterial(int $materialId, string $name, int $unit)
    {
        $material = $this->getMaterial($materialId);
        $material->update(
            [
                'name' => $name,
                'unit' => $unit
            ]
        );
    }

    /**
     * @param int $materialId
     * @throws MaterialManagerException
     */
    public function removeMaterial(int $materialId)
    {
        $material = $this->getMaterial($materialId);
        $material->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getMaterials()
    {
        return Material::all();
    }

    /**
     * @param int $materialId
     * @return mixed
     * @throws MaterialManagerException
     */
    public function getMaterial(int $materialId)
    {
        $material = Material::find($materialId);

        if (null === $material) {
            throw new MaterialManagerException('Матеріал не знайдений');
        }

        return $material;
    }
}