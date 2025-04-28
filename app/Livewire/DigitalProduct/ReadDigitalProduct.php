<?php

namespace App\Livewire\DigitalProduct;

use App\Models\Product;
use Livewire\Component;

class ReadDigitalProduct extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $this->show = Product::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.digital-product.read-digital-product');
    }
}
