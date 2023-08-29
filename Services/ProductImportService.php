<?php

namespace App\Services;

use App\Jobs\ImportCsvProducts;

class ProductImportService
{
    public function importCsv($csvData)
    {
        ImportCsvProducts::dispatch($csvData);
    }
}