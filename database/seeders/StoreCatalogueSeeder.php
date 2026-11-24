<?php
namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class StoreCatalogueSeeder extends Seeder
{
    public function run(): void {
        $data = json_decode(file_get_contents(database_path('data/catalogue.json')), true, flags: JSON_THROW_ON_ERROR);
        foreach ($data['products'] as $product) {
            Product::firstOrCreate(['slug' => Str::slug($product['name'])], $product);
        }
    }
}
