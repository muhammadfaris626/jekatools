<?php

namespace App\Livewire\Pengaturan\Peran;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePengaturanPeran extends Component
{
    public $name, $action;

    public function render()
    {
        Gate::authorize('create', Role::class);
        return view('livewire.pengaturan.peran.create-pengaturan-peran');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new RoleRequest();
        $this->validate($request->rules(), $request->messages());
        Role::create([
            'name' => $this->name
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['name']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('peran.index');
        }
    }
}
