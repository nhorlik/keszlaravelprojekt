<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    // Városok listázása a hozzájuk tartozó megyével együtt
    public function index()
    {
        $cities = City::with('county')->get();
        return response()->json([
            'cities' => $cities,
        ]);
    }

    // Új város mentése (validációval: nevünk legyen, és létező county_id-ra hivatkozzon)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'county_id' => 'required|exists:counties,id',
        ]);

        $city = City::create($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }

    // Meglévő város módosítása ID alapján
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }

    // Város törlése ID alapján
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json([
            'message' => 'City deleted',
        ]);
    }
}