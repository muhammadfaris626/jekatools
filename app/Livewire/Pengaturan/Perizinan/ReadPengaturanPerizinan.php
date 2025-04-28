<?php

namespace App\Livewire\Pengaturan\Perizinan;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ReadPengaturanPerizinan extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = Permission::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'name' => 'Nama Perizinan',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diubah',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'created_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    'updated_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }

    public function render()
    {
        return view('livewire.pengaturan.perizinan.read-pengaturan-perizinan');
    }
}
