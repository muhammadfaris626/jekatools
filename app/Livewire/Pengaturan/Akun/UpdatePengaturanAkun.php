<?php

namespace App\Livewire\Pengaturan\Akun;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdatePengaturanAkun extends Component
{
    public $id, $name, $email, $whatsapp_number, $password, $role_id;
    public $search = "";
    public $fetchRole;

    public function mount($id) {
        $data = User::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name', 'email', 'whatsapp_number', 'password']));
        $this->role_id = $data->roles->first()?->id ?? null;
        $this->fetchRole = Role::all();
    }

    public function render()
    {
        return view('livewire.pengaturan.akun.update-pengaturan-akun');
    }

    public function update() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'whatsapp_number' => 'required',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Harap gunakan format email yang benar.',
            'email.unique' => 'Email ini sudah terdaftar, gunakan email lain.',
            'whatsapp_number.required' => 'Kolom nomor whatsapp wajib diisi.',
            'role_id.required' => 'Kolom peran wajib diisi.'
        ]);
        $user = User::findOrFail($this->id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'whatsapp_number' => $this->whatsapp_number,
            'password' => $this->password === true ? Hash::make('12345678') : $user->password
        ]);
        $role = Role::find($this->role_id);
        $user->syncRoles($role->name);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('akun.index');
    }
}
