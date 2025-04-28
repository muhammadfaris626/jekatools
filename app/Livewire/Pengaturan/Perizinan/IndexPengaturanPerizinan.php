<?php

namespace App\Livewire\Pengaturan\Perizinan;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPengaturanPerizinan extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', Permission::class);
        $data = Permission::latest()->paginate(20);
        if ($this->search != null) {
            $data = Permission::where('name', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(20);
        }
        return view('livewire.pengaturan.perizinan.index-pengaturan-perizinan', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Permission::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
