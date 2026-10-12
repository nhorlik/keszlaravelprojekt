<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;

class CountyController extends Controller
{
    // Megyék listázása a hozzájuk tartozó városokkal (1:N kapcsolat)
    public function index()
    {
        return response()->json([
            'counties' => County::all()
        ]);
    }

    // Új megye mentése (validációval)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $county = County::create($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }

    // Meglévő megye módosítása ID alapján
    public function update(Request $request, $id)
    {
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }

    // Megye törlése ID alapján
    public function destroy($id)
    {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'County deleted',
        ]);
    }
}