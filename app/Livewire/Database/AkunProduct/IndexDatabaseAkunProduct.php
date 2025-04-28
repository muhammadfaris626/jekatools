<?php

namespace App\Livewire\Database\AkunProduct;

use App\Models\AccountItem;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexDatabaseAkunProduct extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', AccountItem::class);
        $data = AccountItem::latest()->paginate(20);
        if ($this->search != null) {
            $data = AccountItem::where('username', 'LIKE', '%' . $this->search . '%')
            ->orWhere('password', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('product', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->latest()->paginate(20);
        }
        return view('livewire.database.akun-product.index-database-akun-product', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = AccountItem::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
