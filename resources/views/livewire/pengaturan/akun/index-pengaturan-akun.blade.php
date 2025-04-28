<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pengaturan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Akun</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:custom.button-create-permission :routeName="'akun'" />
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-2 my-2">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>NAMA</x-table-heading-data>
                    <x-table-heading-data>EMAIL</x-table-heading-data>
                    <x-table-heading-data>NOMOR WHATSAPP</x-table-heading-data>
                    <x-table-heading-data>KODE REFERAL</x-table-heading-data>
                    <x-table-heading-data></x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetch as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->email }}</x-table-body-data>
                        <x-table-body-data>{{ $value->whatsapp_number }}</x-table-body-data>
                        <x-table-body-data>{{ $value->referral_code }}</x-table-body-data>
                        <x-table-body-data :class="'text-right'">
                            <flux:custom.button-list-permission :id="$value->id" :routeName="'akun'" />
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
