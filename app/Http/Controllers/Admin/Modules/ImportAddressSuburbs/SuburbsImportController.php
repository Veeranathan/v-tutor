<?php 
namespace App\Http\Controllers\Admin\Modules\ImportAddressSuburbs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\SuburbsExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AddressSuburbs;

class SuburbsImportController extends Controller
{
    public function showImportSuburbs()
    {
        return view('admin.modules.suburbs_import.excel');
    }

    public function importSuburbs(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 minutes
        ini_set('memory_limit', '512M');  
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);
        AddressSuburbs::truncate();
        Excel::import(new SuburbsExcelImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }
}
