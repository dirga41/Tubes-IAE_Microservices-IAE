<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use App\Jobs\ProcessOrder;
use Illuminate\Support\Facades\Config;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = Http::get('http://userservice:80/api/user-list')->json();
        $products = Http::get('http://productservice:80/api/product-list')->json();
        return view('orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        // Hapus dd() untuk menjalankan kode secara penuh.
        // dd(Config::get('queue.default'));

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::create([
            'user_id' => $request->user_id,
            'status' => 'pending'
        ]);

        // PERBAIKAN: Kirim Job ke koneksi default (rabbitmq) tanpa menentukan antrian.
        // Biarkan worker OrderService yang mengambilnya.
        ProcessOrder::dispatch($order, $validator->validated()['products']);

        return response()->json([
            'message' => 'Order received and is being processed.',
            'order_id' => $order->id
        ], 202);
    }

    public function show(Order $order)
    {
        // Muat relasi 'items' agar ikut tampil di JSON
        return response()->json($order->load('items'));
    }

    public function getOrdersByUser($userId)
    {
        return response()->json(Order::where('user_id', $userId)->get());
    }

    public function getOrdersByProduct($productId)
    {
        return response()->json(Order::where('product_id', $productId)->get());
    }
}
