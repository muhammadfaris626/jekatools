<?php

namespace App\Livewire\Database\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProduct extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', Product::class);
        $data = Product::latest()->paginate(20);
        if ($this->search != null) {
            $data = Product::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('type', 'LIKE', '%' . $this->search . '%')
            ->orWhere('price', 'LIKE', '%' . $this->search . '%')
            ->orWhere('duration_days', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(20);
        }
        return view('livewire.database.product.index-product', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Product::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
