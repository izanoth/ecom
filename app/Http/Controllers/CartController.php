<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Log;
use Exception;

class CartController extends Controller
{
    public function append(Request $request)
    {
        $ip = $request->ip();
        $product_id = $request->get('product_id');
        $units = $request->get('units');

        Auth::check() ?
            $user_id = Auth::id() :
            $user_id = null;

        $existing = Cart::where('ip_address', $ip)
            ->where('product_id', $product_id)
            ->first();
        $existing ?
            [
                $cart = $existing,
                $cart->user_id = $cart->user_id ?? $user_id,
                $cart->units += $units
            ] :
            [
                $cart = new Cart,
                $cart->ip_address = $ip,
                $cart->user_id = $user_id,
                $cart->product_id = $product_id,
                $product = Product::find($product_id),
                $cart->title = $product->title,
                $cart->price = $product->price,
                $cart->images = $product->images,
                $cart->units = $units
            ];

        $cart->save();
        return redirect()->route('home');
    }

    public function remove(Request $request)
    {
        $ip = $request->ip();
        $product = Cart::where('id', $request->get('id'))
            ->where('ip_address', $ip)
            ->get();

        $product->delete();
        return redirect()->route('cart');
    }

    public function async_update(Request $request)
    {
        Log::info('Mensagem de informação.');

        try {
            $id = $request->get('id');
            $units = $request->get('units');
            Cart::where('id', $id)->update(['units' => $units]);
            $cart = Cart::find($id);


            $subtotal = $cart->price * $cart->units;
            
            Log::info('Objeto cart: ' . $cart);

            return response()->json([
                'message' => 'Atualizado com sucesso',
                'subtotal' => $subtotal
            ]);
        } catch (Exception $e) {
            Log::error('Erro ao processar:', ['exception' => $e]);
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}

