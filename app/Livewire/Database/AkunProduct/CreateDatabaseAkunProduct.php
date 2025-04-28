<?php

namespace App\Livewire\Database\AkunProduct;

use App\Http\Requests\AccountItemRequest;
use App\Models\AccountItem;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateDatabaseAkunProduct extends Component
{
    public $product_id, $username, $password, $action;
    public $search = '';
    public $fetchProduct;

    public function mount() {
        $this->fetchProduct = Product::all();
    }

    public function render()
    {
        return view('livewire.database.akun-product.create-database-akun-product');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new AccountItemRequest();
        $this->validate($request->rules(), $request->messages());
        AccountItem::create([
            'product_id' => $this->product_id,
            'username' => $this->username,
            'password' => $this->password
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['product_id', 'username', 'password']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('akun-product.index');
        }
    }
}
