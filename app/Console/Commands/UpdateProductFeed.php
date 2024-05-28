<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class UpdateProductFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:product-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the product feed XML file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $country = getCountry();
        $warehouses = getWebsiteWarehouses();

        $products = Product::where('status', "active")
            ->where('country_id', $country->id)
            ->where(function ($query) use ($warehouses) {
                $query->whereHas('stocks', function ($query) use ($warehouses) {
                    $query->whereIn('warehouse_id', $warehouses);
                })->orWhereIn('product_type', ['digital', 'service'])
                    ->orWhereNotNull('vendor_id');
            })
            ->get();

        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true); // Set indent to false
        $xml->startDocument('1.0', 'UTF-8'); // Move this line to the top
        $xml->startElement('rss');
        $xml->writeAttribute('version', '2.0');
        $xml->writeAttribute('xmlns:g', 'http://base.google.com/ns/1.0');
        $xml->startElement('channel');
        $xml->writeElement('title', 'Proanglesmedia - Rent Media Equipment');
        $xml->writeElement('link', 'https://proanglesmedia.com/');
        $xml->writeElement('description', 'شركه بروانجلز لتآجير معدات تصويرالافلام بالامارات');

        foreach ($products as $product) {
            $xml->startElement('item');
            $xml->writeElement('g:id', $product->id);
            $xml->writeElement('g:title',  app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en);
            $xml->writeElement('g:description', str_replace(['&nbsp;', '&bull;'], '', strip_tags(app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en)));
            $xml->writeElement('g:link', route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]));
            $xml->writeElement('g:image_link', getProductImage($product));
            $xml->writeElement('g:availability', 'in stock');
            $xml->writeElement('g:price', productPrice($product, null, 'vat') . ' ' . getDefaultCurrency()->symbol);
            // Add more product attributes as needed
            $xml->endElement();
        }

        $xml->endElement();
        $xml->endElement();
        $xmlContent = trim($xml->outputMemory());

        $filePath = 'public/products.xml';


        // Save the content to the file in the public storage directory
        Storage::put($filePath, $xmlContent);

        // Get the URL of the saved file
        $fileUrl = Storage::url($filePath);

        // echo "File URL: " . $fileUrl;


        Storage::put('public/products.xml', $xmlContent);

        // // Save XML file to storage or external service
        // Storage::put('products.xml', $xmlContent);

        // Log the update
        $this->info($fileUrl);
    }
}
