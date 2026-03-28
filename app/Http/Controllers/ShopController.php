<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::where('company_id', $request->user()->company_id)
            ->with('city', 'region');

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        $shops   = $query->get();
        $cities  = City::where('company_id', $request->user()->company_id)->get();
        $regions = Region::whereIn('city_id', $cities->pluck('id'))->get();

        return view('shops.index', compact('shops', 'cities', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id'   => 'required|exists:cities,id',
            'region_id' => 'required|exists:regions,id',
            'name'      => 'required|string|max:255',
            'address'   => 'nullable|string',
        ]);

        Shop::create([
            'company_id' => $request->user()->company_id,
            'city_id'    => $request->city_id,
            'region_id'  => $request->region_id,
            'name'       => $request->name,
            'address'    => $request->address,
        ]);

        return redirect()->route('shops.index')
            ->with('success', 'Shop added successfully.');
    }

    public function update(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);
        $request->validate([
            'city_id'   => 'required|exists:cities,id',
            'region_id' => 'required|exists:regions,id',
            'name'      => 'required|string|max:255',
            'address'   => 'nullable|string',
        ]);

        $shop->update($request->only('city_id', 'region_id', 'name', 'address'));

        return redirect()->route('shops.index')
            ->with('success', 'Shop updated successfully.');
    }

    public function destroy(Shop $shop)
    {
        $this->authorize('delete', $shop);
        $shop->delete();

        return redirect()->route('shops.index')
            ->with('success', 'Shop deleted successfully.');
    }
}
