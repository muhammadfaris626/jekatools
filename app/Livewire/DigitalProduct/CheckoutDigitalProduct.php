<?php

namespace App\Livewire\DigitalProduct;

use App\Models\Product;
use App\Models\Transaction;
use App\Services\TripayService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutDigitalProduct extends Component
{
    public $id, $show, $channels;

    public function mount($id) {
        $this->id = $id;
        $this->show = Product::find($id);
        $tripay = new TripayService();
        $this->channels = $tripay->getChannels()['data'] ?? [];
    }
    public function render()
    {
        return view('livewire.digital-product.checkout-digital-product');
    }

    public function transaction($method) {
        $tripay = new TripayService();
        $user = Auth::user();
        $product = Product::findOrFail($this->id);
        $ref = 'INV-JEKATOOLS-' . date('Ymd-His');
        $payload = [
            'method' => $method,
            'merchant_ref' => $ref,
            'amount' => $product->price,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'order_items' => [[
                'sku' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ]],
            'callback_url' => url('/api/tripay/callback'),
            'return_url' => url('/payment/thanks'),
            'expired_time' => now()->addHours(24)->timestamp,
        ];
        $response = $tripay->createTransaction($payload);
        if ($response['success']) {
            Transaction::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'merchant_ref' => $ref,
                'reference' => $response['data']['reference'],
                'amount' => $product->price,
                'fee_merchant' => $response['data']['fee_merchant'],
                'fee_customer' => $response['data']['fee_customer'],
                'total_fee' => $response['data']['total_fee'],
                'amount_received' => $response['data']['amount_received'],
                'payment_method' => $response['data']['payment_name'],
                'pay_code' => $response['data']['pay_code'],
                'payment_url' => $response['data']['checkout_url'],
                'status' => 'UNPAID'
            ]);
            $url = $response['data']['checkout_url'];
            $this->dispatch('open-new-tab', url: $url);
        }
    }
}
