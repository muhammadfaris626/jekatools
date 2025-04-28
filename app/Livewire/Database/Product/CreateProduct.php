<?php

namespace App\Livewire\Database\Product;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;
    public $type = '', $name, $price, $duration_days, $stock, $desc, $thumbnail, $action;

    public function render()
    {
        return view('livewire.database.product.create-product');
    }

    public function updatedType($value) {
        if ($value === 'langganan') {
            $this->stock = null;
        } elseif ($value === 'non-langganan') {
            $this->duration_days = null;
        }
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
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
        Product::create([
            'name' => $this->name,
            'type' => $this->type,
            'price' => str_replace('.', '', $this->price),
            'desc' => $this->desc,
            'duration_days' => $this->duration_days,
            'stock' => $this->stock
        ]);
        $this->reset(['name', 'type', 'price', 'desc', 'duration_days', 'stock']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('product.index');
        }
    }
}
