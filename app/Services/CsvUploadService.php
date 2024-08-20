<?php

namespace App\Services;

use Exception;

class CsvUploadService
{
    public function processCSVFile( $file, array $rowDataKeys, $modelClass)
    {
        $totalRecordsCount = 0; // Initialize the total record count
        $uploadedRecordsCount = 0; // Initialize the uploaded record count
        $errorMessage = null; // Initialize the error message
        $csvFile = fopen(storage_path('app/'.$file), 'r');

        // Skip the first line
        fgetcsv($csvFile);

        // Parse data from CSV file line by line
        while (($line = fgetcsv($csvFile)) !== false) {
            $rowData = array_map('trim', $line); // Trim any whitespace

        // Ensure number of keys matches number of values
        if (count($rowDataKeys) !== count($rowData)) {
            return [
                //'errorMessage'=> new Exception('Invalid data format in CSV file'),
                'errorMessage'=> 'Invalid data format in CSV file. Check your columns',
                'totalRecordsCount' => 'Not Counted',
                'uploadedRecordsCount' => '0',
            ];
        }

            // Ensure keys match the number of columns in the CSV
            $rowData = array_combine($rowDataKeys, $rowData);

            $totalRecordsCount++; // Increment the total record count for each line processed

            // Attempt to insert the row data into the specified Model
            try{
                $modelClass::create($rowData);
                $uploadedRecordsCount++; // Increment the count for each successful insertion
            }catch(Exception $e){
                $errorMessage = "Error occurred during upload to database: " . $e->getMessage();
            }

        }

        fclose($csvFile);
        return [
            'totalRecordsCount' => $totalRecordsCount,
            'uploadedRecordsCount' => $uploadedRecordsCount,
            'errorMessage' => $errorMessage,
        ];
    }
}
