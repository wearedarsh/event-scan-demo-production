<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.attendees.index', $event->id)],
        ['label' => 'Edit attendee'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="{{ $attendee->title }} {{ $attendee->last_name }}"
        subtitle="Edit attendee information, contact details and group assignment."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- MAIN FORM -->
    <div class="px-6 space-y-6">

        <form wire:submit.prevent="update" class="space-y-6">

            <!-- Contact Information -->
            <x-admin.section-title title="Contact information" />

            <x-admin.card hover="false" class="p-6 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Mobile Country Code -->
                    <div>
                        <x-admin.input-label for="mobile_country_code">
                            Mobile Country Code
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="mobile_country_code"
                            model="mobile_country_code"
                        />
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <x-admin.input-label for="mobile_number">
                            Mobile Number
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="mobile_number"
                            model="mobile_number"
                        />
                    </div>

                    <!-- Address Line One -->
                    <div>
                        <x-admin.input-label for="address_line_one">
                            Address Line One
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="address_line_one"
                            model="address_line_one"
                        />
                    </div>

                    <!-- Town -->
                    <div>
                        <x-admin.input-label for="town">
                            Town
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="town"
                            model="town"
                        />
                    </div>

                    <!-- Postcode -->
                    <div>
                        <x-admin.input-label for="postcode">
                            Postcode
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="postcode"
                            model="postcode"
                        />
                    </div>

                </div>

            </x-admin.card>



            <!-- Medical Information -->
            <x-admin.section-title title="Medical information" />

            <x-admin.card hover="false" class="p-6 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Current Position -->
                    <div>
                        <x-admin.input-label for="currently_held_position">
                            Medical Position
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="currently_held_position"
                            model="currently_held_position"
                        />
                    </div>

                    <!-- Attendee Type -->
                    <div>
                        <x-admin.input-label for="attendee_type_id">
                            Attendee Type
                        </x-admin.input-label>
                        <x-admin.select id="attendee_type_id" wire:model="attendee_type_id">
                            <option value="">Select type</option>
                            @foreach ($attendeeTypes as $attendeeType)
                                <option value="{{ $attendeeType->id }}">
                                    {{ $attendeeType->name }}
                                </option>
                            @endforeach
                        </x-admin.select>
                    </div>

                    <!-- Attendee Group -->
                    <div>
                        <x-admin.input-label for="attendee_group_id">
                            Attendee Group (optional)
                        </x-admin.input-label>

                        <x-admin.select id="attendee_group_id" wire:model="attendee_group_id">
                            <option value="">No group allocated</option>
                            @foreach ($attendeeGroups as $group)
                                <option value="{{ $group->id }}">
                                    {{ $group->title }}
                                </option>
                            @endforeach
                        </x-admin.select>

                        @error('attendee_group_id')
                            <x-admin.input-error :message="$message" />
                        @enderror
                    </div>

                </div>

            </x-admin.card>


            <!-- Action buttons -->
            <x-admin.card hover="false" class="p-6 space-y-4">
                <div class="flex items-center gap-3">

                    <x-admin.button type="submit" variant="outline">
                        Update attendee
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.events.attendees.manage', [$event->id, $attendee->id]) }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>
            </x-admin.card>

        </form>

    </div>

</div>
