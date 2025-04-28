<?php

namespace App\Livewire\DigitalProduct;

use App\Models\Transaction;
use Livewire\Component;

class InvoiceDigitalProduct extends Component
{
    public $show;
    public function mount() {
        $this->show = Transaction::where('merchant_ref', request()->query('tripay_merchant_ref'))->first();

    }
    public function render()
    {
        return view('livewire.digital-product.invoice-digital-product');
    }
}
