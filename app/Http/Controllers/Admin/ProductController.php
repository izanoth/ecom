<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->get();
        return view('admin.product.index')->with([
            'products' => $products
        ]);
    }

    public function create()
    {
        $products = Product::with(['category', 'brand'])->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.form')->with([
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();

        if (!($request->has('import_csv'))) {
            try {
                $data = $request->all();
                $fileNames = [];
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('imgs');
                        array_push($fileNames, $path);
                    }
                }

                $product = new Product;
                $product->category_id = $data['category_id'];
                $product->brand_id = $data['brand_id'];
                $product->title = $data['title'];
                $product->specifications = json_decode($data['specifications'], true);
                $product->price = $data['price'];
                $product->images = $fileNames;
                $product->description = $data['description'];
                $product->in_stoch = $data['in_stoch'];
                $product->save();

                return view('admin.product.form')->with([
                    'message' => 'Product created succefully',
                    'categories' => $categories,
                    'brands' => $brands
                ]);
            } catch (Exception $e) {
                return view('admin.product.form')->with([
                    'message' => 'An error occured: ' . $e->getMessage(),
                    'categories' => $categories,
                    'brands' => $brands
                ]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'import_csv' => 'required|file|mimes:csv,txt',
            ]);

            if ($validator->fails()) {
                return view('admin.product.form')->with([
                    'message' => 'Validation Error'
                ]);
            }

            $path = $request->file('import_csv')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $header = array_shift($data);
            try {
                foreach ($data as $row) {
                    $row = array_combine($header, $row);
                    $row['images'] = stripslashes($row['images']);
                    $fileNames = [];
                    foreach (json_decode($row['images']) as $image) {
                        array_push($fileNames, 'imgs/' . $image);
                    }
                    $row['specifications'] = stripslashes($row['specifications']);
                    $product = Product::create([
                        'category_id' => $row['category_id'],
                        'brand_id' => $row['brand_id'],
                        'title' => $row['title'],
                        'specifications' => json_decode($row['specifications'], true),
                        'price' => $row['price'],
                        'images' => $fileNames,
                        'description' => $row['description'],
                        'in_stoch' => $row['in_stoch'],
                    ]);
                    $product->save();
                }
                return view('admin.product.form')->with([
                    'message' => 'Product created succefully',
                    'categories' => $categories,
                    'brands' => $brands
                ]);
            } catch (Exception $e) {
                return view('admin.product.form')->with([
                    'message' => 'An error occured: ' . $e->getMessage(),
                    'categories' => $categories,
                    'brands' => $brands
                ]);
            }
        }
    }

    public function edit(string $id)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::find($id);

        return view('admin.product.form')->with([
            'id' => $id,
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
    public function show(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with(['error' => 'Produto não encontrado'], 404);
        }
        $data = $request->all();
        $categories = Category::all();
        $brands = Brand::all();
        //Handling data
        $fileNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('imgs');
                array_push($fileNames, $path);
            }
        }
        $data['images'] = $fileNames;
        $data['specifications'] = json_decode($data['specifications'], true);
        //\\Handling data\\
        $product->update($data);
        return view('admin.product.form')->with([
            'message' => 'Product updated successfully',
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        Cart::where('product_id', $product->id)->delete();
        $product->delete();
        return redirect()->route('admin.product.index');
    }

    public function insertBelongs(Request $request)
    {
        $data = $request->all();
        $belongs = $data['belongs'];
        $belongs == 'new_category' ?
            $object = new Category :
            $object = new Brand;
        try {
            $new_object = $object->create(['title' => $data['title']]);
            return response()->json([
                'id' => $new_object->id,
                'title' => $new_object->title,
                'message' => 'New belongs inserted succefully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
}