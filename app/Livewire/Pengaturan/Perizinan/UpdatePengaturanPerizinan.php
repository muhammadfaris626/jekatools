<?php

namespace App\Livewire\Pengaturan\Perizinan;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class UpdatePengaturanPerizinan extends Component
{
    public $id, $name;

    public function mount($id) {
        $data = Permission::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name']));
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.pengaturan.perizinan.update-pengaturan-perizinan');
    }

    public function update()
    {
        $request = new PermissionRequest();
        $this->validate($request->rules(), $request->messages());

        Permission::findOrFail($this->id)->update([
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diperbarui.');
        return to_route('perizinan.index');
    }
}
