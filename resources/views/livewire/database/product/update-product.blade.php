<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('product.index')" divider="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:button :href="route('product.index')" size="sm" variant="danger" icon="arrow-left">Kembali</flux:button>
        </div>
    </div>
    <flux:separator />
    <form wire:submit.prevent="update">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
            <div class="md:col-span-4 flex flex-col gap-4 rounded-lg p-4 border dark:border-white/10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <flux:select wire:model.live="type" placeholder="Pilih" label="Jenis Produk" badge="Required">
                            <flux:select.option value="langganan">Langganan</flux:select.option>
                            <flux:select.option value="non-langganan">Non Langganan</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:input wire:model="name" label="Nama Produk" badge="Required" />
                    </div>
                    <div x-data="{ price: @entangle('price').live }" x-init="price = price?.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                        <flux:input.group label="Harga" badge="Required">
                            <flux:input.group.prefix>Rp</flux:input.group.prefix>
                            <flux:input
                                wire:model.lazy="price"
                                x-model="price"
                                x-on:input.debounce.10ms="price = $event.target.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                            />
                        </flux:input.group>
                        <flux:error name="price" />
                    </div>
                    <div>
                        @if($type === 'langganan')
                            <flux:input wire:model="duration_days" label="Durasi Hari" badge="Required" />
                        @endif
                        @if($type === 'non-langganan')
                            <flux:input wire:model="stock" label="Stok Produk" badge="Required" />
                        @endif
                    </div>
                    <div class="col-span-2">
                        <flux:textarea wire:model="desc" label="Keterangan Produk" badge="Required"></flux:textarea>
                    </div>
                </div>
            </div>
        </div>
        <flux:custom.confirm-update />
    </form>
</app>
