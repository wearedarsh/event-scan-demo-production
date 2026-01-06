<?php

namespace App\Livewire\Backend\Admin\Developer\ClientSettings;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ClientSettingCategory;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function render()
    {
        $categories = ClientSettingCategory::query()
            ->withCount('settings')
            ->orderBy('display_order')
            ->get();

        return view('livewire.backend.admin.developer.client-settings.index', [
            'categories' => $categories,
        ]);
    }
}
