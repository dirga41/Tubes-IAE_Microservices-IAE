<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public array $productsData
    ) {}

    public function handle(): void
    {
        // LOG #1: Pastikan data produk diterima oleh Job
        Log::info("Memproses order #{$this->order->id}. Data Produk yang Diterima: " . json_encode($this->productsData));

        if (empty($this->productsData)) {
            Log::warning("Array productsData kosong. Tidak ada item untuk diproses.");
            $this->order->update(['status' => 'failed_no_products']);
            return;
        }

        $totalPrice = 0;
        foreach ($this->productsData as $item) {
            try {
                $productId = $item['product_id'];
                Log::info("Looping untuk produk #{$productId}");

                // Panggil ProductService
                $productResponse = Http::get("http://productservice/api/products/{$productId}");

                // LOG #2: Catat SEMUA respons dari ProductService
                Log::info("Respons dari ProductService untuk produk #{$productId}: Status " . $productResponse->status() . ", Body: " . $productResponse->body());

                // Lanjutkan hanya jika statusnya sukses (2xx)
                if (!$productResponse->successful()) {
                    Log::error("Panggilan HTTP tidak sukses. Melewati produk #{$productId}.");
                    continue;
                }

                // Ambil data JSON dan periksa strukturnya
                $responseData = $productResponse->json();
                if (!isset($responseData['data'])) {
                    Log::error("Kunci 'data' tidak ditemukan dalam respons JSON untuk produk #{$productId}. Melewati.");
                    continue;
                }
                $product = $responseData['data'];

                // Hitung harga
                $priceAtPurchase = $product['price'];
                $totalPrice += $priceAtPurchase * $item['quantity'];

                // Buat OrderItem
                Log::info("Membuat OrderItem untuk produk #{$productId}");
                OrderItem::create([
                    'order_id'   => $this->order->id,
                    'product_id' => $productId,
                    'quantity'   => $item['quantity'],
                    'price'      => $priceAtPurchase,
                ]);

                // Kirim Job untuk mengurangi stok
                Log::info("Mengirim job DecreaseStock untuk produk #{$productId}");
                \App\Jobs\DecreaseStock::dispatch($productId, $item['quantity'])
                     ->onConnection('rabbitmq')->onQueue('stock_updates');

            } catch (\Throwable $e) {
                // LOG #3: Tangkap SEMUA jenis error di dalam loop
                Log::critical("Terjadi error tak terduga saat memproses item: " . $e->getMessage());
                continue;
            }
        }

        // Update total harga dan status
        $this->order->total_price = $totalPrice;
        $this->order->status = 'completed';
        $this->order->save();

        Log::info("Order #{$this->order->id} selesai diproses. Total: {$totalPrice}");
    }
}
