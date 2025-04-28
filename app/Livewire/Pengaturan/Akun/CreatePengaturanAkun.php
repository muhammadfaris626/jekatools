<?php

namespace App\Livewire\Pengaturan\Akun;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Str;

class CreatePengaturanAkun extends Component
{
    public $name, $email, $password, $whatsapp_number, $role_id, $action;
    public $search = "";
    public $fetchRole;

    public function mount() {
        $this->fetchRole = Role::all();
    }

    public function render()
    {
        Gate::authorize('create', User::class);
        return view('livewire.pengaturan.akun.create-pengaturan-akun');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new UserRequest();
        $this->validate($request->rules(), $request->messages());
        $create = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'whatsapp_number' => $this->whatsapp_number,
            'password' => Hash::make($this->password),
            'referral_code' => strtoupper(Str::random(8))
        ]);
        $role = Role::find($this->role_id);
        $create->syncRoles($role->name);
        $this->dispatch('resetDropdown');
        $this->reset(['name', 'email', 'whatsapp_number', 'password', 'role_id']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('akun.index');
        }
    }
}
