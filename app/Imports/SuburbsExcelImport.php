<?php 
namespace App\Imports;

use App\Models\AddressSuburbs;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class SuburbsExcelImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Skip header row if needed
        unset($rows[0]);

        $rows = $rows->splice(1); // Use splice to remove the first row

    $states = [
        'NSW' => 1, 'VIC' => 2, 'QLD' => 3, 'SA' => 4,
        'WA'  => 5, 'TAS' => 6, 'NT'  => 7, 'ACT' => 8,
    ];

    foreach ($rows as $row) {
        // Ensure you're accessing columns correctly.
        // Excel columns are typically 0-indexed when accessed this way.
        // If 'stateName' is in column B, it's index 1.
        // If 'pincode' is in column C, it's index 2.
        // If 'suburb' is in column D, it's index 3.
        $stateName = trim($row[1]); 
        $state_id  = $states[$stateName] ?? 9;
        $pincode   = trim($row[2]);
        $suburb    = trim($row[3]);
        
        AddressSuburbs::create([
            'state_id'    => $state_id,
            'suburb_name' => $suburb,
            'pincode'     => $pincode,
        ]);
    }
}
}