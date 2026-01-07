<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Registration Forms', 'href' => route('admin.developer.registration-form.index')],
        ['label' => $form->label, 'href' => route('admin.developer.registration-form.manage', $form->id)],
        ['label' => 'Add Step'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Add step"
        subtitle="Create a new step for this registration form." />

    <!-- Alerts -->
    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <div class="px-6">
        <form wire:submit.prevent="create" class="space-y-3">

            <x-admin.section-title title="Step details" />

            <x-admin.card hover="false" class="p-6 space-y-4">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label for="label">Label</x-admin.input-label>
                        <x-admin.input-text id="label" model="label" />
                    </div>

                    <div>
                        <x-admin.input-label for="key_name">Step type</x-admin.input-label>
                        <x-admin.select id="key_name" wire:model.live="key_name">
                            <option value="">Select…</option>
                            <option value="dynamic">Dynamic</option>
                            <option value="account">Account</option>
                            <option value="gdpr">GDPR</option>
                            <option value="tickets">Tickets</option>
                            <option value="payment">Payment</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label for="display_order">Display order</x-admin.input-label>
                        <x-admin.input-text id="display_order" model="display_order" />
                    </div>

                </div>

                <x-admin.form-actions
                    submit-text="Create step"
                    :cancel-href="route('admin.developer.registration-form.manage', $form->id)"
                />

            </x-admin.card>

        </form>
    </div>

</div>
