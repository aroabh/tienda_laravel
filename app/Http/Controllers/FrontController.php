<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view ('tienda.nuevo', compact("products"));
    }

    public function showByCategory(Request $request)
    {
        $category = $request->input('category');

        if ($category === 'todo') {
            $products = Product::all();
        } else {
            $products = Product::where('category', $category)->get();
        }

        return view('tienda.nuevo', ['products' => $products]);
    }

    public function resetearCategoria()
    {
        // Obtener todos los productos sin filtrar por categoría
        $products = Product::all();

        return view('tienda.nuevo', ['products' => $products]);
    }
}
