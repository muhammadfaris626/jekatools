<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pengaturan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('perizinan.index')" divider="slash">Perizinan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:button :href="route('perizinan.index')" size="sm" variant="danger" icon="arrow-left">Kembali</flux:button>
            <flux:button :href="route('perizinan.update', $id)" size="sm" variant="primary" icon="pencil-square">Ubah</flux:button>
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-2 my-2">
        <flux:custom.show-data :id="$id" :data="$show" />
    </div>
</app>
