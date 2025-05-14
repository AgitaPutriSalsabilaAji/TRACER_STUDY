<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataImportController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx|max:2048',
        ]);

        // Handle file upload logic here
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        return back()->with('success', 'File uploaded successfully');
    }
}
