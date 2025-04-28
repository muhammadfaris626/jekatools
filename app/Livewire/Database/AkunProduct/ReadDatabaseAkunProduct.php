<?php

namespace App\Livewire\Database\AkunProduct;

use App\Models\AccountItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ReadDatabaseAkunProduct extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = AccountItem::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'product_id' => 'Nama Produk',
            'username' => 'Nama Akun',
            'password' => 'Kata Sandi',
            'is_sold' => 'Status',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diubah',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'product_id' => $list->product->name,
                    'is_sold' => $value == 1 ? 'Terjual' : 'Belum Terjual',
                    'created_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    'updated_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }

    public function render()
    {
        return view('livewire.database.akun-product.read-database-akun-product');
    }
}
