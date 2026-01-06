<?php

namespace App\Livewire\Backend\Admin\Developer\ClientSettings;

use Livewire\Component;
use App\Models\ClientSettingCategory;
use App\Models\ClientSetting;
use Illuminate\Support\Facades\Cache;

use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    public ClientSettingCategory $category;

    public array $values = [];

    public function mount(ClientSettingCategory $category): void
    {
        $this->category = $category->load(['settings']);

        foreach ($this->category->settings as $setting) {
            $this->values[$setting->id] = $setting->value;
        }
    }

    public function update(): void
    {
        foreach ($this->category->settings as $setting) {
            ClientSetting::where('id', $setting->id)->update([
                'value' => $this->values[$setting->id] ?? null,
            ]);
        }

        Cache::forget('client_settings');

        session()->flash('success', 'Client settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.backend.admin.developer.client-settings.manage');
    }
}
