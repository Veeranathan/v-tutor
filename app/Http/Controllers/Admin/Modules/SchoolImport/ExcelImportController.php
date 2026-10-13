<?php 
namespace App\Http\Controllers\Admin\Modules\SchoolImport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\CustomExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\School;

class ExcelImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.modules.school_import.excel');
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 minutes
        ini_set('memory_limit', '512M');  
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);
        School::truncate();
        Excel::import(new CustomExcelImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }
}
