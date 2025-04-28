<?php

namespace App\Livewire\DigitalProduct;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class IndexDigitalProduct extends Component
{
    use WithPagination;
    public $search, $filterStatus;

    public function mount() {
        $this->filterStatus = 'all';
    }

    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function updatingSearch() {
        $this->resetPage();
    }

    public function updatingFilterStatus() {
        $this->resetPage();
    }

    public function render()
    {
        $data = Product::query()
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('price', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('type', $this->filterStatus);
            })->latest()->paginate(12);

        return view('livewire.digital-product.index-digital-product', [
            'fetch' => $data
        ]);
    }
}
