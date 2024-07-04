<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Shipping;
use Illuminate\Support\Facades\Validator;

use Exception;

class ShippingController extends Controller
{
    public function create()
    {
        return view('checkout.new_shipaddr');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'complement' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'zip' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            $shipping = new Shipping;
            $shipping->user_id = $request->user()->id;
            $shipping->receiver = $data['receiver'];
            $phone = str_replace(['(', ')', ' ', '-'], '', $data['phone']);
            $shipping->phone = $phone;
            $shipping->address = $data['address'];
            $shipping->complement = $data['complement'];
            $shipping->city = $data['city'];
            $shipping->district = $data['district'];
            $shipping->zipcode = $data['zip'];
            $shipping->save();

            return redirect()->route('checkout.shipaddr.confirmated')->with('success', 'Endereço de envio salvo com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar o endereço de envio: ' . $e->getMessage());
        }
    }

    public function remove(Request $request)
    {
        $ip = $request->ip();
        $shipping = Shipping::where('id', $request->get('id'))->get();
        if ($request->user()->id == $shipping->user_id) {
            $shipping->delete();
        }
        return redirect()->route('profile.edit');
    }
}
