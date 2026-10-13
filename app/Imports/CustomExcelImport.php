<?php 
namespace App\Imports;

use App\Models\School;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CustomExcelImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Skip header row if needed
        unset($rows[0]);

        foreach ($rows as $row) {
            // Example: Custom transformation
            $acara_id = trim($row[0]);
            $school_name = trim($row[1]);
            $suburb_id= trim($row[2]);
            $states = [
                         'NSW' => 1,
                         'VIC' => 2,
                        'QLD' => 3,
                        'SA'  => 4,
                        'WA'  => 5,
                        'TAS' => 6,
                        'NT'  => 7,
                        'ACT' => 8,
                            ];
            $stateName = trim($row['3']); // or however you get the state column
            $state_id = $states[$stateName] ?? null;
            $postcode=  trim($row[4]);
            
            // Save to DB
               
                School::updateOrCreate(
    ['acara_id' => $acara_id],
    [
        'school_name' => $school_name,
        'suburb_id'   => $suburb_id,
        'state_id'    => $state_id,
        'postcode'    => $postcode,
    ]
);
            
        }
    }
}
