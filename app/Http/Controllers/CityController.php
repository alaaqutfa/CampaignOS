<?php
namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::where('company_id', $request->user()->company_id)
            ->withCount('shops')
            ->get();
        return view('cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        City::create([
            'company_id' => $request->user()->company_id,
            'name'       => $request->name,
        ]);

        return redirect()->route('cities.index')
            ->with('success', 'City added successfully.');
    }

    public function update(Request $request, City $city)
    {
        $this->authorize('update', $city);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city->update(['name' => $request->name]);

        return redirect()->route('cities.index')
            ->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $this->authorize('delete', $city);
        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'City deleted successfully.');
    }
}
