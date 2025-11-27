<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Create Ticket</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Ticket</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Create Ticket</h4>

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

            <form wire:submit.prevent="store" class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Ticket Name</label>
                    <input wire:model.live="name" type="text" class="form-control" id="name" placeholder="eg. Attendee">
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <span class="badge text-bg-light cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Please ensure you use a decimal eg 600.00"><span class="text-brand-dark">more info</span></span>
                    <input wire:model.live="price" type="text" class="form-control" id="price" placeholder="eg. 600.00">
                </div>
                
                <div class="col-md-6">
                    <label for="max_volume" class="form-label">Maximum Volume</label>
                    <span class="badge text-bg-light cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="This is the maximum volume of this ticket a single person can purchase"><span class="text-brand-dark">more info</span></span>
                    <input wire:model.live="max_volume" type="text" class="form-control" id="max_volume">
                </div>

                <div class="col-md-6">
                    <label for="display_order" class="form-label">Display order</label>
                    <input wire:model.live="display_order" type="text" class="form-control" id="display_order">
                </div>

                <div class="col-md-6">
                    <label for="ticket_group_id" class="form-label">Ticket Group</label>
                    <select wire:model.live="ticket_group_id" class="form-select">
                        <option value="">Select a Group</option>
                        @foreach ($ticket_groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="requires_document_upload" class="form-label">Requires Document Upload?</label>
                    <span class="badge text-bg-light cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Set this to yes if this ticket requires a document to be uploaded by the registrant upon purchase"><span class="text-brand-dark">more info</span></span>
                    <select wire:model.live="requires_document_upload" class="form-select">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="requires_document_copy" class="form-label">Document upload copy</label>
                    <span class="badge text-bg-light cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="This is only required if this ticket requires a document to be uploaded upon purchase"><span class="text-brand-dark">more info</span></span>
                    <textarea wire:model.live="requires_document_copy" class="form-control" id="requires_document_copy" rows="4"></textarea>
                </div>

                <div class="col-md-6">
                    <label for="active" class="form-label">Active</label>
                    <select wire:model.live="active" class="form-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="display_front_end" class="form-label">Display on event information page</label>
                    <span class="badge text-bg-light cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="If this is one of your core tickets select yes for this to be displayed on the event information pages"><span class="text-brand-dark">more info</span></span>
                    <select wire:model.live="display_front_end" class="form-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Create Ticket</button>
                    <a href="{{ route('admin.events.tickets.index', $event->id) }}" class="btn btn-light"><span class="text-brand-dark">Cancel</span></a>
                </div>
            </form>
        </div>
    </div>
</div>
