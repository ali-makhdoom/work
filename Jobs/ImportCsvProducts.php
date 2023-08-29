<?php

namespace App\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\DuplicateProductFound;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ImportCsvProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $csvData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csvData)
    {
        $this->csvData = $csvData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $batchSize = 100;
        $csvChunks = array_chunk($this->csvData, $batchSize);
    
        foreach ($csvChunks as $chunk) {
            DB::transaction(function () use ($chunk) {
                foreach ($chunk as $data) {
                    $product = Product::where('sku', $data['Handle'])->first();
    
                    if ($product) {
                        event(new DuplicateProductFound($product->sku));
                    } else {
                        Product::create([
                            'title' => $data['Title'],
                            'description' => $data['Body (HTML)'],
                            'sku' => $data['Handle'],
                            'type' => $data['Type'],
                            'cost_price' => 0.0, // Set the appropriate cost price
                            'status' => ($data['Published'] === 'TRUE') ? 'published' : 'draft',
                        ]);
                    }
                }
            });
        }
    }
}
