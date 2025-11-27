<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Edit Personnel Group</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Personnel Group</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Edit Personnel Group</h4>

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
                    <label for="title" class="form-label">Group Name</label>
                    <input wire:model.live="title" type="text" class="form-control" id="title">
                </div>

                <div class="col-md-3">
                    <label for="label_background_colour" class="form-label">Label Background</label>
                    <input type="color" wire:model.live="label_background_colour" class="form-control" id="label_background_colour" style="width:80px;height:80px;">
                </div>

                <div class="col-md-3">
                    <label for="label_colour" class="form-label">Label Text Colour</label>
                    <input type="color" wire:model.live="label_colour" class="form-control" id="label_colour" style="width:80px;height:80px;">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Update Group</button>
                    <a href="{{ route('admin.events.personnel.index', $event->id) }}" class="btn btn-light"><span class="text-brand-dark">Cancel</span></a>
                </div>
            </form>
        </div>
    </div>
</div>
