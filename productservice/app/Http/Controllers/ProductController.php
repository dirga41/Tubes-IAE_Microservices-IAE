<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    // ----- API -----
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    // app/Http/Controllers/Api/ProductController.php

    public function show($id) // Terima $id sebagai string biasa
    {
        // Cari produk secara manual.
        // findOrFail() akan otomatis menghasilkan error 404 Not Found jika tidak ada,
        // yang jauh lebih informatif daripada respons null.
        $product = Product::findOrFail($id);

        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        if ($request->is('api/*')) {
            return response()->json($product, 201);
        }

        return redirect('/products');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        if ($request->is('api/*')) {
            return response()->json($product);
        }

        return redirect('/products');
    }

    public function destroy(Request $request, $id)
    {
        Product::destroy($id);

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Product deleted']);
        }

        return redirect('/products');
    }

    // ----- Web only -----
    public function create()
    {
        return view('products.create');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function showOrders($id)
    {
        $product = Product::findOrFail($id);
        $orders = Http::get("http://orderservice:80/api/orders/product/$id")->json();
        return view('products.orders', compact('product', 'orders'));
    }
}
