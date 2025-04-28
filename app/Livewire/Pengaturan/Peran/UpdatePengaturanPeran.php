<?php

namespace App\Livewire\Pengaturan\Peran;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class UpdatePengaturanPeran extends Component
{
    public $id, $name;

    public function mount($id) {
        $data = Role::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name']));
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.pengaturan.peran.update-pengaturan-peran');
    }

    public function update()
    {
        $request = new RoleRequest();
        $this->validate($request->rules(), $request->messages());

        Role::findOrFail($this->id)->update([
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diperbarui.');
        return to_route('peran.index');
    }
}
