<div class="space-y-4">

    <x-admin.page-header
        title="Edit field"
        subtitle="Update this registration form input." />

    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <form wire:submit.prevent="update" class="space-y-6">

                <x-admin.section-title title="Field details" />

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label>Label</x-admin.input-label>
                        <x-admin.input-text model="label" />
                    </div>

                    <div>
                        <x-admin.input-label>Key name</x-admin.input-label>
                        <x-admin.input-text model="key_name" />
                    </div>

                    <div>
                        <x-admin.input-label>Type</x-admin.input-label>
                        <x-admin.select wire:model.live="type">
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="select">Select</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label>Placeholder</x-admin.input-label>
                        <x-admin.input-text model="placeholder" />
                    </div>

                </div>

                <x-admin.section-title title="Layout" />

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label>Display order</x-admin.input-label>
                        <x-admin.input-text model="display_order" />
                    </div>

                    <div>
                        <x-admin.input-label>Column span</x-admin.input-label>
                        <x-admin.select wire:model.live="col_span">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label>Is this a row start?</x-admin.input-label>
                        <x-admin.select wire:model.live="row_start">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label>Is this a row end?</x-admin.input-label>
                        <x-admin.select wire:model.live="row_end">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                </div>

                <x-admin.section-title title="Behaviour" />

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label>Required?</x-admin.input-label>
                        <x-admin.select wire:model.live="required">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label>Custom field?</x-admin.input-label>
                        <x-admin.select wire:model.live="custom">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                    @if($type === 'select')
                        <div class="md:col-span-2">
                            <x-admin.input-label>Relation model (optional)</x-admin.input-label>
                            <x-admin.input-text model="relation_model" />
                        </div>
                    @endif

                </div>

                <x-admin.section-title title="Validation" />

                <div class="grid md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">
                        <x-admin.input-label>Validation rules (JSON)</x-admin.input-label>
                        <x-admin.input-textarea
                            model="validation_rules"
                            rows="4" />
                        <x-admin.input-help>
                            eg. ["required", "string", "max:40"]
                        </x-admin.input-help>
                    </div>

                    <div class="md:col-span-2">
                        <x-admin.input-label>Validation messages (JSON)</x-admin.input-label>
                        <x-admin.input-textarea
                            model="validation_messages"
                            rows="4" />
                        <x-admin.input-help>
                            eg. {"required": "Please select a title"}
                        </x-admin.input-help>
                    </div>

                </div>

                <x-admin.form-actions
                    submit-text="Update field"
                    :cancel-href="route('admin.developer.registration-form.steps.manage', $step->id)" />

            </form>

        </x-admin.card>
    </div>

</div>
