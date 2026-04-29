<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('buscar', ''));
        $categoryId = $request->get('categoria');
        $sort = $request->get('orden', 'recientes');

        $categories = Category::withCount('products')
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        $products = Product::with('category')
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

        return view('products.index', compact(
            'products',
            'categories',
            'search',
            'categoryId',
            'sort'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('type')
            ->orderBy('name')
            ->get();

        $product = new Product();

        return view('products.create', compact('categories', 'product'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadProductImage($request, $data['name']);
        } else {
            $data['image'] = null;
        }

        Product::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'El producto fue creado correctamente.');
    }

    public function show(Product $producto)
    {
        $producto->load('category');

        $relatedProducts = Product::with('category')
            ->where('category_id', $producto->category_id)
            ->where('id', '!=', $producto->id)
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $producto,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function edit(Product $producto)
    {
        $categories = Category::orderBy('type')
            ->orderBy('name')
            ->get();

        return view('products.edit', [
            'product' => $producto,
            'categories' => $categories,
        ]);
    }

    public function update(ProductRequest $request, Product $producto)
    {
        $data = $request->validated();

        if ($producto->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $producto->id);
        }

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadProductImage($request, $data['name']);
        } else {
            unset($data['image']);
        }

        $producto->update($data);

        return redirect()
            ->route('productos.show', $producto)
            ->with('success', 'El producto fue actualizado correctamente.');
    }

    public function destroy(Product $producto)
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'El producto fue eliminado correctamente.');
    }

    private function uploadProductImage(ProductRequest $request, string $productName): string
    {
        $file = $request->file('image');

        $directory = public_path('images/productos');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = Str::slug($productName)
            . '-'
            . uniqid()
            . '.'
            . $file->getClientOriginalExtension();

        $file->move($directory, $filename);

        return $filename;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 2;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
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