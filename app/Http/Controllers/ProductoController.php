<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Asegúrate de importar el modelo Producto

class ProductoController extends Controller
{
    public function mostrarFormulario()
    {
        return view('tienda.anadirproducto');
    }

    public function agregarProducto(Request $request)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|string',
            'category' => 'required|string|max:255',
        ]);

        // Procesa y almacena los datos del formulario en la base de datos
        // Aquí deberías escribir el código para almacenar los datos en la base de datos, por ejemplo:
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->image = $validatedData['image'];
        $product->category = $validatedData['category'];

        $product->save();

        // Redirige a alguna vista después de guardar el producto
        return redirect()->route('anadir.agregar')->with('success', 'Producto guardado exitosamente');

    }

    public function editarProducto($id)
    {
        $product = Product::find($id);
        return view('tienda.editarproducto', ['product' => $product]);

    }

    public function actualizarProducto(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->image = $request->input('image');
        $product->category = $request->input('category');
        $product->save();

        return redirect('/')->with('success', 'Producto actualizado correctamente');
    }

    public function borrar($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }

        $product->delete();

        return redirect()->back()->with('success', 'Producto eliminado de la tienda');
    }
}
