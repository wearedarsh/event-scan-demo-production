<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Client Settings', 'href' => route('admin.developer.client-settings.index')],
        ['label' => $category->label],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        :title="$category->label"
        subtitle="Update client-facing configuration and content." />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <!-- Form -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <form wire:submit.prevent="update" class="space-y-6">

                @foreach($category->settings as $setting)

                    <div class="space-y-2">

                        <x-admin.input-label>
                            {{ $setting->label }}
                        </x-admin.input-label>

                        @if($setting->type === 'text')
                            <x-admin.input-text
                                model="values.{{ $setting->id }}"
                                class="w-full" />
                        @endif

                        @if($setting->type === 'textarea')
                            <x-admin.input-textarea
                                model="values.{{ $setting->id }}"
                                rows="5"
                                class="w-full" />
                        @endif

                        @if($setting->type === 'html')
                            <x-admin.editor
                                model="values.{{ $setting->id }}"
                                :label="null" />
                        @endif

                        @if($setting->type === 'select')
                            <x-admin.select wire:model.live="values.{{ $setting->id }}">
                                {{-- Options go here --}}
                            </x-admin.select>
                        @endif

                        <x-admin.input-help>
                            {{ $setting->key_name }}
                        </x-admin.input-help>

                    </div>

                @endforeach

                <!-- Buttons -->
                <x-admin.form-actions
                    submit-text="Save settings"
                    :cancel-href="route('admin.developer.client-settings.index')" />

            </form>

        </x-admin.card>
    </div>

</div>
