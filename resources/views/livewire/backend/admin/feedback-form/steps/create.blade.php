<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Create Feedback Step</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.feedback-form.index', $event->id) }}">Feedback forms</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.feedback-form.manage', [$event->id, $feedback_form->id]) }}">{{ $feedback_form->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Step</li>
            </ol>
        </nav>
    </div>

    @if (session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <span class="font-m">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                <span class="font-m">{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="store" class="bg-white p-4 rounded-2 mt-3 border">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" wire:model.defer="title">
        </div>

        <div class="mb-4">
            <label class="form-label">Order</label>
            <input type="number" class="form-control" wire:model.defer="order">
        </div>

        <div class="col-12">
            <button type="submit" class="btn bg-brand-secondary">Create step</button>
            <a href="{{ route('admin.events.feedback-form.manage', ['event' => $event->id, 'feedback_form' => $feedback_form->id]) }}" class="btn btn-light">
                <span class="text-brand-dark">Cancel</span>
            </a>
        </div>
    </form>
</div>
