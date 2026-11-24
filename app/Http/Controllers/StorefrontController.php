<?php
namespace App\Http\Controllers;
use App\Http\Requests\CatalogueRequest;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;
class StorefrontController extends Controller
{
    public function __invoke(CatalogueRequest $request): Response
    {
        return Inertia::render('welcome', [
            'products' => Product::query()->where('is_visible', true)->orderBy('id')->get(['id', 'name', 'category', 'label', 'accent', 'description']),
            'categories' => config('store.categories'),
            'filters' => $request->validated(),
        ]);
    }
}
