<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\MaterialHistory;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();

        // Apply filters
        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $materials = $query->with(['client', 'user'])->paginate(10);
        // Fetch all clients for the dropdown
        $clients = Client::all();

        $this->logAction('read', 'Viewed materials list');

        return view('materials.index', compact('materials', 'clients'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('materials.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:autre,document,image',
            'content' => 'nullable|string',
            'content_url' => 'nullable|url',
            'field_name' => 'nullable|string|max:255',
        ]);

        $material = Material::create($validated + ['user_id' => Auth::id()]);

        $this->logAction('create', 'Created new material: ' . $material->title);

        return redirect()->route('materials.index')->with('success', 'Material created successfully.');
    }

    public function show(Material $material)
    {
        $this->logAction('read', 'Viewed material: ' . $material->title);

        $client = $material->client; // Récupérer le client associé au matériel

        return view('materials.show', compact('material', 'client'));
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:autre,document,image',
            'content' => 'nullable|string',
            'content_url' => 'nullable|url',
            'field_name' => 'nullable|string|max:255',
        ]);

        $material->update($validated);

        $this->logAction('update', 'Updated material: ' . $material->title);

        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        $materialTitle = $material->title;
        $material->delete();

        $this->logAction('delete', 'Deleted material: ' . $materialTitle);

        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }

    private function logAction($action, $details)
    {
        MaterialHistory::create([
            // 'material_id' => $material->id ?? null,
            'material_id' => null, // Set this to the actual material_id when applicable
            'user_id' => Auth::id(),
            'action' => $action,
            'details' => $details,
        ]);
    }
}
