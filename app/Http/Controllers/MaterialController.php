<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Material;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    protected $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

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

        $this->materialService->createMaterial($validated);

        return redirect()->route('materials.index')->with('success', 'Material created successfully.');
    }

    public function show(Material $material)
    {
        $client = $material->client; // Récupérer le client associé au matériel

        return view('materials.show', compact('material', 'client'));
    }

    public function edit(Material $material)
    {
        $clients = Client::all();
        return view('materials.edit', compact('material', 'clients'));
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

        $this->materialService->updateMaterial($material, $validated);

        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        $this->materialService->deleteMaterial($material);

        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}
