<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Edit personal details</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.bookings.index', ['user' => $user->id, 'registration' => $registration->id]) }}">{{$registration->event->title}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Personal details</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Edit</h4>

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

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Update your details</button>
                    <a href="{{ route('customer.bookings.manage', ['user' => $user->id, 'registration' => $registration->id]) }}" class="btn btn-light">
                        <span class="text-brand-dark">Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
