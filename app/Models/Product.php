<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $fillable = ['slug', 'name', 'category', 'label', 'accent', 'description', 'is_visible'];
    protected function casts(): array { return ['is_visible' => 'boolean']; }
}
