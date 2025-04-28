<?php

namespace App\Livewire\DigitalProduct;

use App\Models\Product;
use App\Services\TripayService;
use Livewire\Component;

class CheckoutDigitalProduct extends Component
{
    public $id, $show, $channels;

    public function mount($id) {
        $this->id = $id;
        $this->show = Product::find($id);
        $tripay = new TripayService();
        dd($tripay->getChannels());
        $this->channels = $tripay->getChannels()['date'] ?? [];
        dd($this->channels);
    }
    public function render()
    {
        return view('livewire.digital-product.checkout-digital-product');
    }
}
