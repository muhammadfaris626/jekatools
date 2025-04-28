<?php

namespace App\Livewire\Database\Product;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ReadProduct extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = Product::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'type' => 'Jenis Produk',
            'name' => 'Nama Produk',
            'price' => 'Harga',
            'duration_days' => 'Durasi Hari',
            'stock' => 'Stok Produk',
            'desc' => 'Keterangan',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diubah',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'price' => 'Rp. ' . number_format($value, 0, ',', '.'),
                    'duration_days' => $value . ' Hari',
                    'created_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    'updated_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }

    public function render()
    {
        return view('livewire.database.product.read-product');
    }
}
