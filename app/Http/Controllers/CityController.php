<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function manageCity(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:100',
        ]);

        $city = $request->id ? City::find($request->id) : new City;
        $city->city = $request->city;
        $city->save();

        return response()->json($city, 201);
    }

    public function deleteCity($id)
    {
        $city = City::find($id);
        if ($city) {
            $city->delete();
            return response()->json(['message' => 'City deleted successfully']);
        }
        return response()->json(['message' => 'City not found'], 404);
    }

    public function getCity($id)
    {
        $city = City::find($id);
        return response()->json($city);
    }

    public function getAllCities()
    {
        $cities = City::all();
        return response()->json($cities);
    }
}