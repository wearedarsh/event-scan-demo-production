<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Create Feedback Question</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.feedback-form.index', $event->id) }}">Feedback forms</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.feedback-form.manage', [$event->id, $feedback_form->id]) }}">{{ $feedback_form->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Question</li>
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

    @if ($errors->any())
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                <span class="font-m">{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="store" class="bg-white p-4 rounded-2 mt-3 border">
        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" class="form-control" wire:model="question_text">
        </div>

        <div class="mb-3">
            <label class="form-label">Order</label>
            <input type="number" class="form-control" wire:model="order">
        </div>

        <div class="mb-4">
            <label class="form-label">{{ $type }} Question type</label>
            <select class="form-select" wire:model.live="type">
                <option value="">Select question type</option>
                <option value="radio">Radio</option>
                <option value="multi-select">Multi-select</option>
                <option value="text">Text</option>
                <option value="textarea">Textarea</option>
            </select>
        </div>

        @if(in_array($type, ['radio', 'multi-select']))
            <div class="mb-4">
                <label class="form-label">Options (comma separated)</label>
                <input type="text" class="form-control" wire:model="options_text" placeholder="e.g. Yes, No, Maybe">
            </div>
        @endif

        <div class="mb-4">
            <label class="form-label">Is this question optional?</label>
            <select class="form-select" wire:model.live="is_optional">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        @if($is_optional === '1')

            <div class="mb-4">
                <label class="form-label">Required question</label>
                <select class="form-select" wire:model.defer="visible_if_question_id">
                    <option value="">Select triggering question</option>
                    @foreach($conditional_questions as $question)
                        <option value="{{ $question->id }}">{{ $question->question }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Please type the option the user selects to trigger this question eg. Other.</label>
                <input type="text" class="form-control" wire:model.defer="visible_if_answer" placeholder="eg. Other">
            </div>
        @endif

        <div class="col-12">
            <button type="submit" class="btn bg-brand-secondary">Create question</button>
            <a href="{{ route('admin.events.feedback-form.manage', [$event->id, $feedback_form->id]) }}" class="btn btn-light">
                <span class="text-brand-dark">Cancel</span>
            </a>
        </div>
    </form>
</div>
