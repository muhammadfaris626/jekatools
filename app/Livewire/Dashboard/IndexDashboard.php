<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class IndexDashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard.index-dashboard');
    }

    public function tes() {
        $url = 'https://google.com';
        $this->dispatch('open-new-tab', url: $url);
    }
}
