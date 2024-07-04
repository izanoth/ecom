<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

use App\Helpers\Functions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;


class ViewController extends Controller
{
    public function welcome(Request $request)
    {
        
        $ip = $request->ip();
        Functions::setCartSession($ip);

        $products = session()->get('cart_products');
        $display_products = Product::orderByRaw('RAND()')->limit(9)->get();

        return view('home', ['products' => $display_products]);
    }
    public function product(Request $request)
    {
        $id = $request->get('id');
        $product = Product::findOrFail($id);
        return view('product', compact('product'));
    }
    public function cart(Request $request)
    {
        $ip = $request->ip();
        $amount = session()->get('amount');
        if (Auth::check()) {
            $cart_products = session()->get('cart_products');
            return view('cart', compact('cart_products', 'amount'));
        } else {
            return redirect()->route('home');
        }
    }
    public function search(Request $request)
    {
        $keywords = $request->input('keyword');
        $keywordsArray = explode(' ', $keywords);
        $products = collect();
        foreach ($keywordsArray as $keyword) {
            $foundProducts = Product::where('title', 'like', "%$keyword%")
                ->orWhere('description', 'like', "%$keyword%")
                ->get();
            $products = $products->merge($foundProducts);
        }
        $products = $products->unique();
        return view('home', compact('products'));
    }
    public function checkout()
    {
        if (Auth::check()) {
            return view('checkout');
        } else {
            return redirect()->route('login');
        }
    }
}
