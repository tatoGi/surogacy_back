<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('translations')->get();



        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validationRules = [
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:companies',
            'password' => 'required|string|min:8',
        ];

        foreach(config('app.locales') as $locale) {
            $validationRules[$locale.'.name'] = 'required|string|max:255';
            $validationRules[$locale.'.slug'] = 'required|string|max:255|unique:company_translations,slug';
            $validationRules[$locale.'.country'] = 'required|string|max:255';
            $validationRules[$locale.'.description'] = 'nullable|string';
        }

        $request->validate($validationRules);

        try {
            $company = new Company();
            $company->phone = $request->phone;
            $company->email = $request->email;
            $company->password = Hash::make($request->password);
            $company->save();

            foreach (config('app.locales') as $locale) {
                $company->translateOrNew($locale)->name = $request->input($locale.'.name');
                $company->translateOrNew($locale)->slug = $request->input($locale.'.slug');
                $company->translateOrNew($locale)->country = $request->input($locale.'.country');
                $company->translateOrNew($locale)->description = $request->input($locale.'.description');
            }
            $company->save();

            return redirect()->route('admin.companies.index')
                ->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating company: ' . $e->getMessage());
        }
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {

        $validationRules = [
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:companies,email,' . $company->id,
        ];

        if ($request->filled('password')) {
            $validationRules['password'] = 'required|string|min:8|confirmed';
        }

        foreach(config('app.locales') as $locale) {
            $validationRules[$locale.'.name'] = 'required|string|max:255';
            $validationRules[$locale.'.slug'] = 'required|string|max:255|unique:company_translations,slug,' . $company->id . ',company_id';
            $validationRules[$locale.'.country'] = 'required|string|max:255';
            $validationRules[$locale.'.description'] = 'nullable|string';
        }

        $request->validate($validationRules);

        try {
            $company->phone = $request->phone;
            $company->email = $request->email;

            if ($request->filled('password')) {
                $company->password = Hash::make($request->password);
            }

            $company->save();

            foreach (config('app.locales') as $locale) {
                $company->translateOrNew($locale)->name = $request->input($locale.'.name');
                $company->translateOrNew($locale)->slug = $request->input($locale.'.slug');
                $company->translateOrNew($locale)->country = $request->input($locale.'.country');
                $company->translateOrNew($locale)->description = $request->input($locale.'.description');
            }
            $company->save();

            return redirect()->route('admin.companies.index' , [app()->getLocale()])
                ->with('success', 'Company updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating company: ' . $e->getMessage());
        }
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index' , [app()->getLocale()])
            ->with('success', 'Company deleted successfully.');
    }
}
