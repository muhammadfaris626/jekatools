<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Platform</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Produk Digital</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex flex-col md:flex-row gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:select size="sm" wire:model.live="filterStatus" placeholder="Jenis Produk">
                <flux:select.option value="all">Semua Jenis</flux:select.option>
                <flux:select.option value="langganan">Langganan</flux:select.option>
                <flux:select.option value="non-langganan">Non Langganan</flux:select.option>
            </flux:select>
            <flux:custom.button-create-permission :routeName="'pengajuan-invoice'" />
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 my-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @foreach($fetch as $key => $value)
                <div class="rounded-lg bg-zinc-100 dark:bg-zinc-600 p-1">
                    <img class="rounded-lg h-48 w-full object-cover" src="{{ asset('images/product3.png') }}" />
                    <flux:heading size="lg" class="text-center py-2">{{ $value->name }}</flux:heading>
                    <div>
                        <flux:button :href="route('digital-product.read', $value->id)" class="w-full">Lihat</flux:button>
                    </div>
                </div>
            @endforeach
        </div>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
