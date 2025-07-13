<?php

namespace App\Services;

use App\Models\Division;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DivisionService
{
    public function index($params = [])
    {
        $nama = $params['name'] ?? null;
        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 10;

        // Logic for listing all Divisions
        return Division::query()
            ->where('name', 'like', "%{$nama}%")
            ->paginate($limit);
    }


    public function store(Request $request)
    {
        // Validate and store new Division
        $validated = $this->validateData($request);
        return Division::create($validated);
    }

    public function show(Division $Division)
    {
        // Logic for showing single Division
        return $Division;
    }


    public function update(Request $request, Division $Division)
    {
        // Validate and update existing Division
        $validated = $this->validateData($request);
        $Division->update($validated);
        return $Division;
    }

    public function destroy(Division $Division)
    {
        // Logic for deleting Division
        $Division->delete();
        return response()->json(['message' => 'Division deleted successfully']);
    }

    private function validateData(Request $request)
    {
        // Validation logic
        return $request->validate([
            // Add your validation rules here
        ]);
    }
}
