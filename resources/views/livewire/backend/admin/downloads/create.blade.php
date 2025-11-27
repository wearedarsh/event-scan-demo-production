<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Create Event Download</h2>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <form wire:submit.prevent="store" class="row g-3" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="title" class="form-label">Title</label>
                <input wire:model.defer="title" type="text" class="form-control" id="title">
            </div>

            <div class="col-md-6">
                <label for="display_order" class="form-label">Display Order</label>
                <input wire:model.defer="display_order" type="number" class="form-control" id="display_order">
            </div>

            <div class="col-md-6">
                <label for="active" class="form-label">Active</label>
                <select wire:model="active" class="form-select">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="col-12">
                <label for="file" class="form-label">File</label>
                <input wire:model="file" type="file" class="form-control" id="file">
                @error('file') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn bg-brand-secondary">Create Download</button>
                <a href="{{ route('admin.events.content.index', $event->id) }}" class="btn btn-light"><span class="text-brand-dark">Cancel</span></a>
            </div>
        </form>
    </div>
</div>
