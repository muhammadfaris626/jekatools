<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('akun-product.index')" divider="slash">Akun Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Tambah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:button :href="route('akun-product.index')" size="sm" variant="danger" icon="arrow-left">Kembali</flux:button>
        </div>
    </div>
    <flux:separator />
    <form wire:submit.prevent="store">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
            <div class="md:col-span-4 flex flex-col gap-4 rounded-lg p-4 border dark:border-white/10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Nama Produk</flux:label>
                            <flux:select wire:model="product_id" variant="listbox" placeholder="Pilih Produk" :options="$fetchProduct" />
                            <flux:error name="product_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:input wire:model="username" label="Nama Akun" badge="Required" />
                    </div>
                    <div>
                        <flux:input wire:model="password" label="Kata Sandi Akun" badge="Required" />
                    </div>
                </div>
            </div>
        </div>
        <flux:custom.confirm-create />
    </form>
</app>
