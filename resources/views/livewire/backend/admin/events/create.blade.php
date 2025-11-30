<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => 'Create Event'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Create Event"
        subtitle="Enter core details to create a new event." />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- FORM -->
    <div class="px-6">
        <form wire:submit.prevent="save" class="space-y-3">

            <!-- Event Details -->
            <x-admin.section-title title="Event details" />

            <x-admin.card hover="false" class="p-6 space-y-4">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label for="title">Title</x-admin.input-label>
                        <x-admin.input-text id="title" model="title" />
                    </div>

                    <div>
                        <x-admin.input-label for="location">Location</x-admin.input-label>
                        <x-admin.input-text id="location" model="location" />
                    </div>

                    <div>
                        <div class="flex items-center gap-1">
                            <x-admin.input-label for="date_start">Start Date</x-admin.input-label>
                            <x-admin.tooltip text="Enter date using dd-mm-yyyy format">
                                <x-admin.icon-info />
                            </x-admin.tooltip>
                        </div>
                        <x-admin.input-text
                            id="date_start"
                            model="date_start"
                            class="datepicker"
                            autocomplete="off"
                        />
                    </div>

                    <div>
                        <div class="flex items-center gap-1">
                            <x-admin.input-label for="date_end">End Date</x-admin.input-label>
                            <x-admin.tooltip text="Enter date using dd-mm-yyyy format">
                                <x-admin.icon-info />
                            </x-admin.tooltip>
                        </div>
                        <x-admin.input-text
                            id="date_end"
                            model="date_end"
                            class="datepicker"
                            autocomplete="off"
                        />
                    </div>

                    <div>
                        <x-admin.input-label for="event_attendee_limit">Attendee Limit</x-admin.input-label>
                        <x-admin.input-text id="event_attendee_limit" model="event_attendee_limit" />
                    </div>

                    <div>
                        <x-admin.input-label for="vat_percentage">VAT Percentage</x-admin.input-label>
                        <x-admin.input-text id="vat_percentage" model="vat_percentage" />
                    </div>

                </div>

            </x-admin.card>



            <!-- Event Status -->
            <x-admin.section-title title="Event status" />

            <x-admin.card hover="false" class="p-6 space-y-4">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label for="active">Is the event active?</x-admin.input-label>
                        <x-admin.select id="active" wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label for="full">Is the event full?</x-admin.input-label>
                        <x-admin.select id="full" wire:model.live="full">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label for="provisional">Is the event provisional?</x-admin.input-label>
                        <x-admin.select id="provisional" wire:model.live="provisional">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label for="template">Is this event a template?</x-admin.input-label>
                        <x-admin.select id="template" wire:model.live="template">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

            </x-admin.card>



            <!-- Email Marketing -->
            <x-admin.section-title title="Email marketing" />

            <x-admin.card hover="false" class="p-6 space-y-4">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label for="auto_email_opt_in">Auto email opt-in?</x-admin.input-label>
                        <x-admin.select id="auto_email_opt_in" wire:model.live="auto_email_opt_in">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <x-admin.input-label for="show_email_marketing_opt_in">Show opt-in statement?</x-admin.input-label>
                        <x-admin.select id="show_email_marketing_opt_in" wire:model.live="show_email_marketing_opt_in">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <div>
                    <x-admin.input-label for="email_opt_in_description">
                        Email opt-in description
                    </x-admin.input-label>

                    <x-admin.input-textarea
                        id="email_opt_in_description"
                        model="email_opt_in_description"
                        rows="4"
                    />
                </div>

            </x-admin.card>



            <!-- Action Buttons -->
            <x-admin.card hover="false" class="p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <x-admin.button type="submit" variant="outline">
                        Create Event
                    </x-admin.button>

                    <x-admin.button href="{{ route('admin.events.index') }}" variant="secondary">
                        Cancel
                    </x-admin.button>
                </div>
            </x-admin.card>

        </form>
    </div>

</div>
