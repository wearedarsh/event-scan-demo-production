<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">{{$attendee->title}} {{$attendee->last_name}}</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.attendees.index', $event->id) }}">Attendees</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Edit Attendee</h4>

            @if($errors->any())
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <span class="font-m">{{ $errors->first() }}</span>           
                    </div>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        <span class="font-m">{{ session('success') }}</span>           
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="update" class="row g-3">
                <!-- <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                        <select wire:model="title" class="form-control">
                        <option value="Dr">Dr</option>
                        <option value="Mr">Mr</option> 
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option> 
                        <option value="Ms">Ms</option> 
                        <option value="Professor">Professor</option> 
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input wire:model.live="first_name" type="text" class="form-control" id="first_name">
                </div>

                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input wire:model.live="last_name" type="text" class="form-control" id="last_name">
                </div> -->

                <div class="col-md-6">
                    <label for="mobile_country_code" class="form-label">Mobile Country Code</label>
                    <input wire:model.live="mobile_country_code" type="text" class="form-control" id="mobile_country_code">
                </div>

                <div class="col-md-6">
                    <label for="mobile_number" class="form-label">Mobile Number</label>
                    <input wire:model.live="mobile_number" type="text" class="form-control" id="mobile_number">
                </div>

                <div class="col-md-6">
                    <label for="address_line_one" class="form-label">Address Line One</label>
                    <input wire:model.live="address_line_one" type="text" class="form-control" id="address_line_one">
                </div>

                <div class="col-md-6">
                    <label for="town" class="form-label">Town</label>
                    <input wire:model.live="town" type="text" class="form-control" id="town">
                </div>

                <div class="col-md-6">
                    <label for="postcode" class="form-label">Postcode</label>
                    <input wire:model.live="postcode" type="text" class="form-control" id="postcode">
                </div>

                <div class="col-md-6">
                    <label for="currently_held_position" class="form-label">Medical Position</label>
                    <input wire:model.live="currently_held_position" type="text" class="form-control" id="currently_held_position">
                </div>

                <div class="col-md-6">
                    <label for="attendee_type_id" class="form-label">Medical attendeeType</label>
                    <select wire:model.live="attendee_type_id" class="form-select" id="attendee_type_id">
                        <option value="">Select attendeeType</option>
                        @foreach ($attendeeTypes as $attendeeType)
                            <option value="{{ $attendeeType->id }}">{{ $attendeeType->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="attendee_group_id" class="form-label">Attendee Group (optional)</label>
                    <select id="attendee_group_id" class="form-select" wire:model.live="attendee_group_id">
                        <option value="">No group allocated</option>
                        @foreach ($attendeeGroups as $dg)
                            <option value="{{ $dg->id }}">{{ $dg->title }}</option>
                        @endforeach
                    </select>
                    @error('attendee_group_id') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Update Attendee</button>
                    <a href="{{ route('admin.events.attendees.manage', ['event' => $event->id, 'attendee' => $attendee->id]) }}" class="btn btn-light">
                        <span class="text-brand-dark">Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
