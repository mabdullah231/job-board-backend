<?php

namespace App\Http\Controllers;

use App\Models\ApplicationFile;
use Illuminate\Http\Request;

class ApplicationFileController extends Controller
{
    public function manageApplicationFile(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string',
            'application_id' => 'required|exists:job_applications,id',
        ]);

        $applicationFile = $request->id ? ApplicationFile::find($request->id) : new ApplicationFile;
        $applicationFile->fill($request->all());
        $applicationFile->save();

        return response()->json($applicationFile, 201);
    }

    public function deleteApplicationFile($id)
    {
        $applicationFile = ApplicationFile::find($id);
        if ($applicationFile) {
            $applicationFile->delete();
            return response()->json(['message' => 'ApplicationFile deleted successfully']);
        }
        return response()->json(['message' => 'ApplicationFile not found'], 404);
    }

    public function getApplicationFile($id)
    {
        $applicationFile = ApplicationFile::find($id);
        return response()->json($applicationFile);
    }

    public function getAllApplicationFiles()
    {
        $applicationFiles = ApplicationFile::all();
        return response()->json($applicationFiles);
    }
}