<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Imports\ArticlesImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(ImportRequest $request)
    {
        try {
            Excel::import(new ArticlesImport, $request->file('file'));
            return response()->json(['message' => 'File imported successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Import failed', 'error' => $e->getMessage()], 500);
        }
    }
}
