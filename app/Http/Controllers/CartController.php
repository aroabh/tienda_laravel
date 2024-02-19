<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $producto = Product::find($request->id);
        if(empty($producto))
            return redirect('/');

        Cart::add(
            $producto->id,
            $producto->name,
            1,
            $producto->price,
            ["image"=>$producto->image]
        );

        return redirect()->back()->with("success", "Artículo agregado al carrito: ". $producto->name);
    }

    public function checkout()
    {
        return view ('cart/checkout');
    }

    public function removeItem(Request $request){
        $rowId = $request->rowId;
        $item = Cart::get($rowId);

        if ($item->qty > 1) {
            // Si hay más de una unidad, simplemente disminuir la cantidad
            Cart::update($rowId, $item->qty - 1);
        } else {
            // Si solo hay una unidad, eliminar la fila completa
            Cart::remove($rowId);
        }

        return redirect()->back()->with("success", "Artículo eliminado!");
    }

    public function clear()
    {
        // Lógica para simular la compra
        Cart::destroy(); // Vacía el carrito

        return redirect()->back()->with("success", "Pedido tramitado, en breve te llegará un email con toda la información");
    }


}
