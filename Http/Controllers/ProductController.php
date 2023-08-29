<?php

namespace App\Http\Controllers;

use App\Facades\ProductImporterFacade;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function importProducts()
    {
        $csvFilePath = public_path('products.csv'); // Replace with the actual path to your CSV file
    
        if (!file_exists($csvFilePath)) {
            return "CSV file not found.";
        }
    
        $csvData = [];
        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            $headers = fgetcsv($handle); // Read the header row
            while (($row = fgetcsv($handle)) !== false) {
                $csvData[] = array_combine($headers, $row);
            }
            fclose($handle);
        } else {
            return "Error reading CSV file.";
        }
    
        ProductImporterFacade::importCsv($csvData);
    
        return "CSV import initiated!";
    }
}
