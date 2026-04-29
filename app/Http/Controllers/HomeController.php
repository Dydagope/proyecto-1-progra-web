<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('buscar', ''));

        $products = Product::with('category')
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
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::withCount('products')
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('home.index', compact(
            'products',
            'featuredProducts',
            'categories',
            'search'
        ));
    }
}