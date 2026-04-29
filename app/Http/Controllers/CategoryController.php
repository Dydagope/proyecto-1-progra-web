<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function wine(Request $request)
    {
        return $this->listByType($request, 'Vino', 'Catálogo de vinos');
    }

    public function champagne(Request $request)
    {
        return $this->listByType($request, 'Champán', 'Catálogo de champanes');
    }

    public function show(Request $request, Category $category)
    {
        $search = trim($request->get('buscar', ''));
        $sort = $request->get('orden', 'recientes');

        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('name', 'like', "%{$search}%")
                        ->orWhere('producer', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('grape', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%")
                        ->orWhere('vintage_year', 'like', "%{$search}%");
                });
            });

        $products = $this->applySorting($products, $sort)
            ->paginate(8)
            ->withQueryString();

        $categories = Category::withCount('products')
            ->where('type', $category->type)
            ->orderBy('name')
            ->get();

        $title = $category->name;

        return view('categories.show', compact(
            'category',
            'products',
            'categories',
            'title',
            'search',
            'sort'
        ));
    }

    private function listByType(Request $request, string $type, string $title)
    {
        $search = trim($request->get('buscar', ''));
        $sort = $request->get('orden', 'recientes');
        $categoryId = $request->get('categoria');

        $categories = Category::withCount('products')
            ->where('type', $type)
            ->orderBy('name')
            ->get();

        $products = Product::with('category')
            ->whereHas('category', function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('name', 'like', "%{$search}%")
                        ->orWhere('producer', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('grape', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%")
                        ->orWhere('vintage_year', 'like', "%{$search}%");
                });
            });

        $products = $this->applySorting($products, $sort)
            ->paginate(8)
            ->withQueryString();

        $category = null;

        return view('categories.show', compact(
            'category',
            'products',
            'categories',
            'title',
            'search',
            'sort',
            'categoryId'
        ));
    }

    private function applySorting($query, string $sort)
    {
        return match ($sort) {
            'precio_asc' => $query->orderBy('price', 'asc'),
            'precio_desc' => $query->orderBy('price', 'desc'),
            'nombre' => $query->orderBy('name', 'asc'),
            'anio_desc' => $query->orderBy('vintage_year', 'desc'),
            default => $query->latest(),
        };
    }
}