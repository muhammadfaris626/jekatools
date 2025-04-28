<?php

namespace App\Livewire\Pengaturan\Akun;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ReadPengaturanAkun extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = User::with('roles')->find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'name' => 'Nama',
            'email' => 'Email',
            'whatsapp_number' => 'Nomor Whatsapp',
            'referral_code' => 'Kode Referal',
            'referred_by' => 'Referal Dari',
            'roles' => 'Peran',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diubah',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'roles' => $list->roles->pluck('name')->join(', ') ?: '-',
                    'created_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    'updated_at' => Carbon::parse($value)->translatedFormat('l, d F Y H:i:s'),
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }

    public function render()
    {
        return view('livewire.pengaturan.akun.read-pengaturan-akun');
    }
}
