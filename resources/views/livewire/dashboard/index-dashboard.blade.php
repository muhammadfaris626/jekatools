<app>
    <flux:button wire:click="tes">KLIK</flux:button>
</app>
@push('scripts')
    <script>
        Livewire.on('open-new-tab', url => {
            window.open(url.url, '_blank');
        });
    </script>
@endpush

