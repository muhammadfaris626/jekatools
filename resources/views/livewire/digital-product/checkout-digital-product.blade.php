<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Platform</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('digital-product.index')" divider="slash">Produk Digital</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">{{ $show->name }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Checkout</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:button :href="route('digital-product.read', $show->id)" size="sm" variant="danger" icon="arrow-left">Kembali</flux:button>
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 mt-4">
        <flux:heading size="lg" class="text-center">Pilih Metode Pembayaran Anda</flux:heading>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @foreach($channels as $key => $value)
                <form wire:submit.prevent="transaction('{{ $value['code'] }}')">
                    @php
                        $bankImages = [
                            'BNIVA' => 'bni.png',
                            'BRIVA' => 'bri.png',
                            'MANDIRIVA' => 'mandiri.png',
                            'BCAVA' => 'bca.png',
                            'QRIS' => 'shopeepay.png',
                            'QRIS2' => 'qris.png'
                        ];
                        $image = $bankImages[$value['code']] ?? 'default.png';
                    @endphp
                    <div class="rounded-lg bg-zinc-100 dark:bg-zinc-600 p-1">
                        <div class="rounded-lg p-4 bg-white">
                            <img class="h-16 w-full object-contain" src="{{ asset('images/bank/' . $image) }}" />
                        </div>
                        <flux:heading size="md" class="text-center mt-2">Pembayaran</flux:heading>
                        <flux:heading size="md" class="text-center mb-2">{{ $value['name'] }}</flux:heading>
                    </div>
                    <div class="mt-2">
                        <flux:button type="submit" variant="primary" size="sm" class="w-full">PILIH</flux:button>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
</app>

@push('scripts')
    <script>
        Livewire.on('open-new-tab', url => {
            window.open(url.url, '_blank');
        });
    </script>
@endpush
