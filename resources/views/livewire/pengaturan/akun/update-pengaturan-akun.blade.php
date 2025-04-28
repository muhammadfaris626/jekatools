<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pengaturan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('akun.index')" divider="slash">Akun</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:button :href="route('akun.index')" size="sm" variant="danger" icon="arrow-left">Kembali</flux:button>
        </div>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="update">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input wire:model="name" label="Nama" badge="Required" />
                    </div>
                    <div>
                        <flux:input wire:model="email" label="Email" badge="Required" />
                    </div>
                    <div>
                        <flux:input wire:model="whatsapp_number" label="Nomor Whatsapp" badge="Required" />
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Peran</flux:label>
                            <flux:select wire:model="role_id" variant="listbox" placeholder="Pilih Peran" :options="$fetchRole" :selectedData="$role_id" />
                            <flux:error name="role_id" />
                        </flux:field>
                    </div>
                    <div class="col-span-2">
                        <flux:checkbox wire:model="password" label="Reset Password ( password: 12345678 )" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-update />
        </form>
    </div>
</app>
