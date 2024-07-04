<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Shipping;
use App\Helpers\Functions;
use Exception;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        Functions::setCartSession($request->ip());
        
        $user_id = $request->user()->id;
        $shippings = Shipping::where('user_id', $user_id)->get();
        $products = session()->get('cart_products');
        $amount = session()->get('amount');
        return view('checkout.show', compact('products', 'amount', 'shippings', 'user_id'));
        //return redirect()->route('login');
    }

    public function process(Request $request)
    {
        /*$user_id = $request->user()->id;
        $shippings = Shipping::where('user_id', $user_id)->get();
        if (!$shippings->isEmpty()) {
            return view('checkout.process', ['shippings' => $shippings]);
        } else {
            return redirect()->route('checkout.shipaddr.create');
        }*/
    }
    public function payChoice(Request $request)
    {
        return view('checkout.paychoice');
    }

    public function success()
    {
        //return view('checkout-success');
    }
}
