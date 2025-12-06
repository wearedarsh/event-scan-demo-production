<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.registrations.index', $event->id)],
        ['label' => $attendee->title . ' ' . $attendee->last_name, 'href' => route('admin.events.registrations.manage', [$event->id, $attendee->id])],
        ['label' => 'Edit registration'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="{{ $attendee->title }} {{ $attendee->last_name }}"
        subtitle="Edit registration contact information and professional details."
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


            <!-- Contact Details -->
            <x-admin.section-title title="Contact details" />

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
                            Town / City
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



            <!-- Professional Details -->
            <x-admin.section-title title="Professional details" />

            <x-admin.card hover="false" class="p-6 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Company / Position -->
                    <div>
                        <x-admin.input-label for="currently_held_position">
                            Company
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="currently_held_position"
                            model="currently_held_position"
                        />
                    </div>

                    <!-- Profession -->
                    <div>
                        <x-admin.input-label for="attendee_type_id">
                            Profession
                        </x-admin.input-label>

                        <x-admin.select id="attendee_type_id" wire:model="attendee_type_id">
                            <option value="">Select attendee type</option>
                            @foreach ($attendeeTypes as $attendeeType)
                                <option value="{{ $attendeeType->id }}">
                                    {{ $attendeeType->name }}
                                </option>
                            @endforeach
                        </x-admin.select>
                    </div>

                </div>

            </x-admin.card>



            <!-- Action buttons -->
            <x-admin.card hover="false" class="p-6 space-y-4">

                <div class="flex items-center gap-3">

                    <x-admin.button type="submit" variant="outline">
                        Update registration
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.events.registrations.manage', [$event->id, $attendee->id]) }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>

            </x-admin.card>

        </form>

    </div>

</div>
