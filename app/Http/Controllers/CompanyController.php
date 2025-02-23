<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storag;

class CompanyController extends Controller
{
    public function manageCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as an image
        ]);

        // Automatically set the user_id to the authenticated employer's ID
        $company = $request->id ? Company::find($request->id) : new Company;
        $company->name = $request->name;
        $company->description = $request->description;
        $company->user_id = Auth::id(); // Set the user_id to the authenticated employer's ID

        // Handle the logo upload
        if ($request->hasFile('logo')) {
            // Create the uploads directory if it doesn't exist
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true); // Create the directory with appropriate permissions
            }

            // Move the uploaded file to the public/uploads directory
            $logoPath = $request->file('logo')->move($uploadPath, $request->file('logo')->getClientOriginalName());
            $company->logo = 'uploads/' . $request->file('logo')->getClientOriginalName(); // Save the path in the logo column
        }

        // Save the company
        $company->save();

        return response()->json($company, 201);
    }

    public function deleteCompany($id)
    {
        $company = Company::where('id', $id)->where('user_id', Auth::id())->first(); // Ensure the company belongs to the authenticated employer
        if ($company) {
            $company->delete();
            return response()->json(['message' => 'Company deleted successfully']);
        }
        return response()->json(['message' => 'Company not found or you do not have permission to delete this company'], 404);
    }

    public function getCompany()
    {
        $company = Company::where('user_id', Auth::id())->first(); // Ensure the company belongs to the authenticated employer
        if ($company) {
            return response()->json($company);
        }
        return response()->json(['message' => 'Company not found or you do not have permission to view this company'], 404);
    }

    public function getAllCompanies()
    {
        $companies = Company::withCount('jobs')->get(); // Get all companies for the authenticated employer
        return response()->json($companies);
    }
}
