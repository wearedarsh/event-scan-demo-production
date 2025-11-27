<div>

    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Feedback Forms</h2>
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

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Feedback Forms</li>
            </ol>
        </nav>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3">
        <div class="col-12">
            <h5>Communication</h5>
                <a class="btn bg-brand-secondary"
                    href="{{ route('admin.events.emails.send-email', ['event' => $event->id, 'audience' => 'attendees_incomplete_feedback', 'lock' => 1]) }}">
                    <span class="cil-envelope-closed me-2"></span><span class="text-brand-light">Send email reminder</span>
                </a>
        </div>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">

        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m" style="margin-bottom:150px;">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th style="width: 150px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->feedbackFormsAll as $form)
                        <tr>
                            <td>{{ $form->title }}</td>
                            <td>
                                @if($form->active)
                                    <span class="badge text-bg-success font-m"><span class="font-s text-white fw-normal">Active</span></span>
                                @else
                                    <span class="badge text-bg-danger font-m"><span class="font-s text-white fw-normal">Inactive</span></span>
                                @endif
                            </td>
                            <td>
                                

                                <div class="dropdown">
                                    <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item font-m" href="{{ route('admin.events.feedback-form.manage', [$event->id, $form->id]) }}">Manage</a></li>
                                        <li><a class="dropdown-item font-m" href="{{ route('admin.events.feedback-form.preview.index', [$event->id, $form->id]) }}">Preview</a></li>
                                        <li><a class="dropdown-item font-m" href="{{ route('admin.events.reports.feedback.pdf.export', [$event->id, $form->id]) }}">Download report</a></li>
                                        <li><a class="dropdown-item font-m" href="{{ route('admin.events.reports.feedback.view', ['event' => $event->id, 'feedback_form' => $form->id]) }}">View report</a></li>
                                        
                                        <li><a class="dropdown-item font-m" href="{{ route('admin.events.feedback-form.edit', [$event->id, $form->id]) }}">Edit</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No feedback forms found for this event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
