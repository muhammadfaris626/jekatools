<?php

namespace App\Livewire\Pengaturan\Peran;

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ReadPengaturanPeran extends Component
{
    public $id, $show, $fetch;

    public function mount($id) {
        $list = Role::find($id);
        Gate::authorize('view', $list);
        $this->show = $list;
        $this->fetch = $this->permission();
    }

    public function render()
    {
        return view('livewire.pengaturan.peran.read-pengaturan-peran');
    }

    public function permission() {
        $allPermissions = [
            // Database
            'product', 'akun-product',
            // Pengaturan
            'akun', 'peran', 'perizinan',
        ];
        $categoryNames = [
            // Database
            'product' => 'PRODUK',
            'akun-product' => 'AKUN PRODUK',
            // Pengaturan
            'akun' => 'AKUN',
            'peran' => 'PERAN',
            'perizinan' => 'PERIZINAN',
        ];
        $list = [];
        $order = ['menu', 'create', 'read', 'update', 'delete'];
        foreach ($allPermissions as $key => $value) {
            $displayName = $categoryNames[$value] ?? $value;
            $list[$key] = [
                0 => 'role_id',
                1 => $this->show->id,
                'category' => $displayName
            ];
            $query = Permission::query();
            $query->where('name', 'REGEXP', "^" . preg_quote($value) . "(:|$)");
            $permissions = $query->get()->sortBy(function ($perm) use ($order) {
                $parts = explode(':', $perm->name);
                $suffix = $parts[1] ?? 'menu'; // default ke "menu" kalau tidak ada suffix
                return array_search($suffix, $order) !== false ? array_search($suffix, $order) : 999;
            });
            foreach ($permissions as $data) {
                $check = DB::table('role_has_permissions')
                    ->where('role_id', $this->show->id)
                    ->where('permission_id', $data->id)
                    ->exists();
                $status = $check ? 1 : 0;
                $list[$key][$displayName][$data->id] = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'status' => $status
                ];
            }
        }
        return $list;
    }

    public function updatePermission($role, $permission) {
        $checkRolePermission = DB::table('role_has_permissions')->where('role_id', $role)->where('permission_id', $permission)->first();
        $searchRole = Role::where('id', $role)->first();
        $searchPermission = Permission::where('id', $permission)->first();
        if (empty($checkRolePermission)) {
            $searchRole->givePermissionTo($searchPermission);
            $searchPermission->assignRole($searchRole);
            LivewireAlert::text('Perizinan ditambahkan.')->success()->toast()->position('top-end')->show();
        } else {
            $searchRole->revokePermissionTo($searchPermission);
            $searchPermission->removeRole($searchRole);
            LivewireAlert::text('Perizinan dihapus.')->success()->toast()->position('top-end')->show();
        }
        return back();
    }
}
