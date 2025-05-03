<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $companies = Company::with(['surrogatePeople' => function($query) {
            $query->where('active', true);
        }])->paginate(10);

        return view('admin.pages.favorites.index', compact('companies'));
    }

    public function show(Company $company)
    {
        $favorites = $company->surrogatePeople()
            ->where('active', true)
            ->paginate(10);

        return view('admin.pages.favorites.show', compact('company', 'favorites'));
    }
}
