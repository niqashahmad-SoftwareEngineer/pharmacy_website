<?php
namespace Tests\Feature;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\StoreCatalogueSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
class StorefrontTest extends TestCase
{
    use RefreshDatabase;
    public function test_storefront_returns_preserved_catalogue_and_filters(): void {
        $this->seed(StoreCatalogueSeeder::class);
        $this->get('/?q=skin&category=Personal%20Care')->assertOk()->assertInertia(fn(Assert $page)=>$page->component('welcome')->has('products',8)->has('categories',6)->where('filters.q','skin'));
    }
    public function test_hidden_products_are_not_exposed(): void {
        $this->seed(StoreCatalogueSeeder::class);
        $product=Product::firstOrFail();$product->update(['is_visible'=>false]);
        $this->get('/')->assertInertia(fn(Assert $page)=>$page->has('products',7));
        $this->assertFalse(Gate::allows('view',$product));
    }
    public function test_filters_are_validated(): void {
        $this->getJson('/?category=invalid')->assertUnprocessable()->assertJsonValidationErrors('category');
        $this->getJson('/?q='.str_repeat('a',121))->assertUnprocessable()->assertJsonValidationErrors('q');
    }
    public function test_seeding_preserves_existing_edits(): void {
        $this->seed(StoreCatalogueSeeder::class);$product=Product::firstOrFail();$product->update(['description'=>'Existing content']);
        $this->seed(StoreCatalogueSeeder::class);
        $this->assertSame(8,Product::count());$this->assertSame('Existing content',$product->fresh()->description);
    }
    public function test_catalogue_writes_are_not_authorized_for_registered_users(): void {
        $user=User::factory()->create();
        $this->assertFalse(Gate::forUser($user)->allows('create',Product::class));
    }
}
