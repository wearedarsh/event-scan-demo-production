<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Edit feedback form</h2>
    </div>

    @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <span class="font-m">{{ $errors->first() }}</span>           
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <span class="font-m">{{ session('success') }}</span>           
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="update" class="bg-white p-4 rounded-2 mt-3 border">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" wire:model.defer="title">
        </div>

        <div class="mb-4">
            <label class="form-label" for="active">Active</label>
            <select wire:model.live="active" class="form-select" id="role">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
            </select>
            
        </div>

        <div class="mb-4">
            <label class="form-label" for="is_anonymous">Anonymous</label>
            <select wire:model.live="is_anonymous" class="form-select" id="is_anonymous">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label" for="multi_step">Multi-step</label>
            <select wire:model.live="multi_step" class="form-select" id="multi_step">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn bg-brand-secondary">Update feedback form</button>
        <a href="{{ route('admin.events.feedback-form.index', $event->id) }}" class="btn btn-light"><span class="text-brand-dark">Cancel</span></a>
    </form>
</div>
