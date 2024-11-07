<?php

namespace App\Services;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    public function createMaterial(array $data)
    {
        $material = Material::create($data + ['user_id' => Auth::id()]);

        // Log the action
        $this->logAction('create', 'Created new material: ' . $material->title, $material->id);

        return $material;
    }

    public function updateMaterial(Material $material, array $data)
    {
        $material->update($data);

        // Log the action
        $this->logAction('update', 'Updated material: ' . $material->title, $material->id);

        return $material;
    }

    public function deleteMaterial(Material $material)
    {
        $materialTitle = $material->title;
        $material->delete();

        // Log the action
        $this->logAction('delete', 'Deleted material: ' . $materialTitle, $material->id);

        return true;
    }

    private function logAction($action, $details, $materialId = null)
    {
        MaterialHistory::create([
            'material_id' => $materialId,
            'user_id' => Auth::id(),
            'action' => $action,
            'details' => $details,
        ]);
    }
}
