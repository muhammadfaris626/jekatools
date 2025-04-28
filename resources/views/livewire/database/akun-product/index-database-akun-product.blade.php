<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Produk</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:custom.button-create-permission :routeName="'akun-product'" />
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-2 my-2">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>NAMA PRODUK</x-table-heading-data>
                    <x-table-heading-data>AKUN</x-table-heading-data>
                    <x-table-heading-data>PASSWORD</x-table-heading-data>
                    <x-table-heading-data>STATUS</x-table-heading-data>
                    <x-table-heading-data></x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetch as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->product->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->username }}</x-table-body-data>
                        <x-table-body-data>{{ $value->password }}</x-table-body-data>
                        <x-table-body-data>
                            <flux:badge color="{{ $value->is_sold == 1 ? 'green' : 'red' }}" size="sm">{{ $value->is_sold == 1 ? 'Terjual' : 'Belum Terjual' }}</flux:badge>
                        </x-table-body-data>
                        <x-table-body-data :class="'text-right'">
                            <flux:custom.button-list-permission :id="$value->id" :routeName="'akun-product'" />
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
