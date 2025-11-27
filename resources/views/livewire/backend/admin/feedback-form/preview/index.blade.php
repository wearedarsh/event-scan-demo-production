<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">[PREVIEW] {{ $form->title }}<br><span class="font-m">{{ $form->event->title }}</span></h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3 overflow-auto">
        <nav aria-label="breadcrumb" class="w-max">
            <ol class="breadcrumb d-flex flex-nowrap align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Feedback form</li>
            </ol>
        </nav>
    </div>

    @if ($form->multi_step)
        @include('livewire.backend.admin.feedback-form.preview.partials.multi-step')
    @else
        @include('livewire.backend.admin.feedback-form.preview.partials.single-page')
    @endif

</div>
