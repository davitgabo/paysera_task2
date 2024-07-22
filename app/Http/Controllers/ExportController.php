<?php

namespace App\Http\Controllers;

use App\Exports\BlankExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportBlankExcel()
    {
        return Excel::download(new BlankExport, 'blank.xlsx');
    }
}
