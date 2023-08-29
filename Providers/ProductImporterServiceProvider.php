<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProductImportService;

class ProductImporterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('product-importer', function ($app) {
            return new ProductImportService();
        });
    }
}