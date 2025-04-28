<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Platform</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('digital-product.index')" divider="slash">Produk Digital</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">{{ $show->name }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Checkout</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:button :href="route('digital-product.index')" size="sm" variant="danger" icon="arrow-left">Kembali</flux:button>
        </div>
    </div>
    <flux:separator />
    {{-- <div class="grid grid-cols-1 gap-4 my-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-2">
            <div class="md:col-span-2 flex flex-col">
                <div class="relative rounded-lg bg-white dark:bg-zinc-600 p-2">
                    <img class="rounded-lg h-48 w-full object-cover" src="{{ asset('images/product3.png') }}" />
                    <div class="mt-2">
                        <flux:button :href="route('digital-product.checkout', $show->id)" variant="primary" class="w-full" icon="shopping-cart">Checkout</flux:button>
                    </div>
                </div>
            </div>
            <div class="md:col-span-4 flex flex-col">
                <div class="relative flex-1 rounded-lg bg-white dark:bg-zinc-600 p-4">
                    <div>
                        <flux:badge color="sky">{{ ucfirst(strtolower($show->type)) }}</flux:badge>
                    </div>
                    <div class="mt-2">
                        <flux:heading size="lg">{{ $show->name }}</flux:heading>
                    </div>
                    <div class="mt-2">
                        <flux:heading>Harga</flux:heading>
                        <flux:text size="xl">{{ 'Rp ' . number_format($show->price, 0, ',', '.') }}</flux:text>
                    </div>
                    <div class="mt-2">
                        <flux:heading>Keterangan</flux:heading>
                        <flux:text class="mt-2">{!! $show->desc !!}</flux:text>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</app>
