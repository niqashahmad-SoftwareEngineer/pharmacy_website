<?php
namespace App\Http\Requests;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
class CatalogueRequest extends FormRequest
{
    public function authorize(): bool { return Gate::allows('viewAny', Product::class); }
    public function rules(): array {
        return ['q' => ['nullable', 'string', 'max:120'], 'category' => ['nullable', 'string', Rule::in(array_column(config('store.categories'), 'name'))]];
    }
}
