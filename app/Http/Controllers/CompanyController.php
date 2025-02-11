<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function manageCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $company = $request->id ? Company::find($request->id) : new Company;
        $company->name = $request->name;
        $company->description = $request->description;
        $company->logo = $request->logo;
        $company->user_id = $request->user_id;
        $company->save();

        return response()->json($company, 201);
    }

    public function deleteCompany($id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->delete();
            return response()->json(['message' => 'Company deleted successfully']);
        }
        return response()->json(['message' => 'Company not found'], 404);
    }

    public function getCompany($id)
    {
        $company = Company::find($id);
        return response()->json($company);
    }

    public function getAllCompanies()
    {
        $companies = Company::all();
        return response()->json($companies);
    }
}
