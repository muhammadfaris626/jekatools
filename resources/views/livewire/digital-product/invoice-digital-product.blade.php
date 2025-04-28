<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Platform</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('digital-product.index')" divider="slash">Produk Digital</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Faktur Pembelian</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:button size="sm" variant="primary" icon="arrow-down-tray">Unduh</flux:button>
            <flux:button size="sm" variant="filled" icon="printer">Simpan & Cetak</flux:button>
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 mt-4 rounded-lg bg-white dark:bg-zinc-600 px-10 py-8">
        <div>
            <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center">
                <div>
                    <img class="h-16 w-full object-contain" src="{{ asset('images/logo.png') }}" />
                    <flux:heading size="xl" class="text-center">Jekatools</flux:heading>
                </div>
                <div>
                    <flux:text class="text-right">Jekatools</flux:text>
                    <flux:text class="text-right">Email : jekatools@system.com</flux:text>
                    <flux:text class="text-right">Website : <flux:link href="https://member.jekatools.com">https://member.jekatools.com</flux:link></flux:text>
                    <flux:text class="text-right">Nomor Kontak : 08123456789</flux:text>
                </div>
            </div>
        </div>
        <div>
            <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center px-20">
                <div>
                    <flux:heading>{{ $show->merchant_ref }}</flux:heading>
                    <flux:text>Nomor Faktur</flux:text>
                </div>
                <flux:separator vertical />
                <div>
                    <flux:heading>{{ Carbon\Carbon::parse($show->updated_at)->format('d F Y') }}</flux:heading>
                    <flux:text>Tanggal Pembelian</flux:text>
                </div>
                <flux:separator vertical />
                <div>
                    <flux:heading>
                        <flux:badge color="green" size="sm">LUNAS</flux:badge>
                    </flux:heading>
                    <flux:text>Status Pembayaran</flux:text>
                </div>
                <flux:separator vertical />
                <div>
                    <flux:heading>
                        {{ 'Rp ' . number_format($show->amount, 0, ',', '.') }}
                    </flux:heading>
                    <flux:text>Total Pembayaran</flux:text>
                </div>
            </div>
        </div>
        <div>
            <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center">
                <div>
                    <flux:heading>Bayar Ke : </flux:heading>
                    <flux:text>Jekatools</flux:text>
                    <flux:text>Jalan Sudiang Raya, Makassar</flux:text>
                    <flux:text>+628123456789</flux:text>
                </div>
                <div>
                    <flux:heading>Faktur Ke : </flux:heading>
                    <flux:text>{{ $show->user->name }}</flux:text>
                    <flux:text>{{ $show->user->email }}</flux:text>
                    <flux:text>{{ $show->user->whatsapp_number }}</flux:text>
                </div>
            </div>
        </div>
        <div>
            <x-table>
                <x-table-heading>
                    <x-table-heading-row>
                        <x-table-heading-data>NO</x-table-heading-data>
                        <x-table-heading-data>NAMA PRODUK</x-table-heading-data>
                        <x-table-heading-data>HARGA</x-table-heading-data>
                        <x-table-heading-data>JUMLAH</x-table-heading-data>
                        <x-table-heading-data>TOTAL</x-table-heading-data>
                    </x-table-heading-row>
                </x-table-heading>
                <x-table-body>
                    <x-table-body-row>
                        <x-table-body-data :class="'py-2 w-4'">1</x-table-body-data>
                        <x-table-body-data>{{ $show->product->name }}</x-table-body-data>
                        <x-table-body-data>{{ 'Rp ' . number_format($show->amount, 0, ',', '.') }}</x-table-body-data>
                        <x-table-body-data>1</x-table-body-data>
                        <x-table-body-data>{{ 'Rp ' . number_format($show->amount, 0, ',', '.') * 1 }}</x-table-body-data>
                    </x-table-body-row>
                </x-table-body>
            </x-table>
        </div>
        <div>
            <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
                <div>

                </div>
                <div class="flex gap-4">
                    <flux:heading size="lg">TOTAL : </flux:heading>
                    <flux:heading size="lg">{{ 'Rp ' . number_format($show->amount, 0, ',', '.') * 1 }}</flux:heading>
                </div>
            </div>
        </div>
        <div>
            <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center">
                <div>
                    <flux:heading>RINCIAN PEMBAYARAN</flux:heading>
                    <flux:text>Metode Pembayaran : {{ $show->payment_method }}</flux:text>
                    <flux:text>Kode Pembayaran : {{ $show->pay_code }}</flux:text>
                    <flux:text>Total Pembayaran : {{ 'Rp ' . number_format($show->amount, 0, ',', '.') * 1 }}</flux:text>

                </div>
                <div>

                </div>
            </div>
        </div>
    </div>
</app>
