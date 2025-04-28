<?php

namespace App\Livewire\Database\AkunProduct;

use App\Http\Requests\AccountItemRequest;
use App\Models\AccountItem;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class UpdateDatabaseAkunProduct extends Component
{
    public $id, $product_id, $username, $password;
    public $fetchProduct;
    public $search = "";

    public function mount($id) {
        $data = AccountItem::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'product_id', 'username', 'password']));
        $this->fetchProduct = Product::all();
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.database.akun-product.update-database-akun-product');
    }

    public function update() {
        $request = new AccountItemRequest();
        $this->validate($request->rules(), $request->messages());
        AccountItem::findOrFail($this->id)->update([
            'product_id' => $this->product_id,
            'username' => $this->username,
            'password' => $this->password
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('akun-product.index');
    }
}
