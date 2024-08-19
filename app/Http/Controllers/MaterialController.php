<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Client $client)
    {
        $materials = $client->materials()->paginate(15);
        return view('materials.index', compact('client', 'materials'));
    }
    

    public function create(Client $client)
    {
        return view('materials.create', compact('client'));
    }

    public function store(StoreMaterialRequest $request, Client $client)
    {
        $material = new Material($request->validated());
        $material->client_id = $client->id;
        $material->user_id = auth()->id();

        if ($request->hasFile('content')) {
            $path = $request->file('content')->store('materials', 'public');
            $material->content = $path;
        }

        $material->save();

        return redirect()->route('clients.materials.index', $client)
            ->with('success', 'Document ajouté avec succès.');
    }

    public function show(Client $client, Material $material)
    {
        return view('materials.show', compact('client', 'material'));
    }

    public function edit(Client $client, Material $material)
    {
        return view('materials.edit', compact('client', 'material'));
    }

    public function update(UpdateMaterialRequest $request, Client $client, Material $material)
    {
        $material->fill($request->validated());

        if ($request->hasFile('content')) {
            $path = $request->file('content')->store('materials', 'public');
            $material->content = $path;
        }

        $material->save();

        return redirect()->route('clients.materials.index', $client)
            ->with('success', 'Document mis à jour avec succès.');
    }

    public function destroy(Client $client, Material $material)
    {
        $material->delete();
        return redirect()->route('clients.materials.index', $client)
            ->with('success', 'Document supprimé avec succès.');
    }
}
