<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DecreaseStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $productId,
        public int $quantity
    ) {}

    public function handle(): void
    {
        Log::info("Job DecreaseStock: Mencoba mengurangi stok produk #{$this->productId} sebanyak {$this->quantity}");
        $product = \App\Models\Product::find($this->productId);
        if ($product && $product->stock >= $this->quantity) {
            $product->stock -= $this->quantity;
            $product->save();
            Log::info("Stok produk #{$this->productId} berhasil dikurangi.");
        } else {
            Log::error("Gagal mengurangi stok produk #{$this->productId}. Stok tidak cukup atau produk tidak ditemukan.");
            // Di sini bisa ditambahkan logika untuk kompensasi/pemberitahuan
        }
    }
}
