<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class OrderHistoryController extends Controller
{
    public function index($userId) {
        $response = Http::get("http://orderservice:80/api/orders/user/$userId");
        return response()->json($response->json());
    }

    public function indexView($userId) {
        $response = Http::get("http://orderservice:80/api/orders/user/$userId");
        $orders = $response->json();
    
        foreach ($orders as &$order) {
            $productResponse = Http::get("http://productservice:80/api/product/" . $order['product_id']);
            $order['product'] = $productResponse->successful() ? $productResponse->json() : null;
        }
    
        return view('orders.history', compact('orders'));
    }
    
}
