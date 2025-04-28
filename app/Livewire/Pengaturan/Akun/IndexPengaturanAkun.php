<?php

namespace App\Livewire\Pengaturan\Akun;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPengaturanAkun extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', User::class);
        $data = User::latest()->paginate(20);
        if ($this->search != null) {
            $data = User::where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                ->orWhere('whatsapp_number', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(20);
        }
        return view('livewire.pengaturan.akun.index-pengaturan-akun', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = User::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
