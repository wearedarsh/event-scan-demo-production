<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Edit Ticket Group</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Ticket Group</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Edit Ticket Group</h4>

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
                    <label for="name" class="form-label">Group Name</label>
                    <input wire:model="name" type="text" class="form-control" id="name">
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <input wire:model="description" type="text" class="form-control" id="description">
                </div>

                <div class="col-md-6">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input wire:model="display_order" type="number" class="form-control" id="display_order">
                </div>

                <div class="col-md-6">
                    <label for="multiple_select" class="form-label">Allow Multiple Selection</label>
                    <select wire:model.live="multiple_select" class="form-select" id="multiple_select">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="required" class="form-label">Is Required</label>
                    <select wire:model.live="required" class="form-select" id="required">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="active" class="form-label">Is Active</label>
                    <select wire:model.live="active" class="form-select" id="active">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Update Ticket Group</button>
                    <a href="{{ route('admin.events.tickets.index', ['event' => $event->id]) }}" class="btn btn-light">
                        <span class="text-brand-dark">Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
