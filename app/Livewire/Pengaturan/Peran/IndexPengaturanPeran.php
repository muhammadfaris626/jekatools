<?php

namespace App\Livewire\Pengaturan\Peran;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPengaturanPeran extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', Role::class);
        $data = Role::latest()->paginate(20);
        if ($this->search != null) {
            $data = Role::where('name', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(20);
        }
        return view('livewire.pengaturan.peran.index-pengaturan-peran', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Role::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
