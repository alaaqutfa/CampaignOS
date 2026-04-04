<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreCompanyRequest;
use App\Http\Requests\SuperAdmin\UpdateCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(20);
        return view('super-admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('super-admin.companies.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $path         = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        Company::create($data);

        return redirect()->route('super-admin.companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('super-admin.companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $path         = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        $company->update($data);

        return redirect()->route('super-admin.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('super-admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}
