<?php

namespace App\Livewire\Database\Product;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Livewire\Component;

class UpdateProduct extends Component
{
    public $id, $name, $type, $price, $desc, $duration_days, $stock;
    public function mount($id) {
        $data = Product::findOrFail($id);
        $this->fill($data->only(['id', 'name', 'type', 'price', 'desc', 'duration_days', 'stock']));
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.database.product.update-product');
    }

    public function update() {
        $request = new ProductRequest();
        $rules = $request->rules();
        $messages = $request->messages();
        if ($this->type == 'langganan') {
            $rules['duration_days'] = 'required';
            $messages['duration_days.required'] = 'Kolom durasi hari wajib diisi.';
        } elseif ($this->type == 'non-langganan') {
            $rules['stock'] = 'required';
            $messages['stock.required'] = 'Kolom stok produk wajib diisi.';
        }
        $this->validate($rules, $messages);
        Product::findOrFail($this->id)->update([
            'name' => $this->name,
            'type' => $this->type,
            'price' => str_replace('.', '', $this->price),
            'desc' => $this->desc,
            'duration_days' => $this->duration_days,
            'stock' => $this->stock
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('product.index');
    }
}
