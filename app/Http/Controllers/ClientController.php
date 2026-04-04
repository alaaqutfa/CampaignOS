<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('company_id', Auth::user()->company_id)
            ->withCount('campaigns')
            ->get();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Client::create([
            'company_id'   => Auth::user()->company_id,
            'access_token' => Str::random(32),
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'address'      => $request->address,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client created.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $client->update($request->all());
        return redirect()->route('clients.index')->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted.');
    }
}
