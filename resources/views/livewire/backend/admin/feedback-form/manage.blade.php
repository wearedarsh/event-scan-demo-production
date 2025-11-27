<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Manage Feedback Form</h2>
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

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{$event->title}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.feedback-form.index', $event->id) }}">Feedback forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$feedback_form->title}}</li>
            </ol>
        </nav>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3">
        <div class="col-12">
            <h5>Tools</h5>
            <a href="{{ route('admin.events.reports.feedback.view', ['event' => $event->id, 'feedback_form' => $feedback_form->id]) }}"
               class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
                <span class="cil-arrow-right me-2"></span>
                <span class="text-brand-light">View report</span>
            </a>

            <a href="{{ route('admin.events.reports.feedback.pdf.export', [$event->id, $feedback_form->id]) }}"
               class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
                <span class="cil-arrow-right me-2"></span>
                <span class="text-brand-light">Download Report</span>
            </a>

            <a href="{{ route('admin.events.feedback-form.preview.index', [$event->id, $feedback_form->id]) }}"
               class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
                <span class="cil-arrow-right me-2"></span>
                <span class="text-brand-light">Preview form</span>
            </a>
        </div>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3">
        <div class="col-12">
            <h5>Information</h5>
            @if($feedback_form->active)
                <span class="badge text-bg-success font-m"><span class="font-s text-white fw-normal">Active</span></span>
            @else
                <span class="badge text-bg-danger font-m"><span class="font-s text-white fw-normal">Inactive</span></span>
            @endif
        </div>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h4>Steps</h4>
            </div>
            <div class="col-sm-3">
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{ route('admin.events.feedback-form.steps.create', ['event' => $event->id, 'feedback_form' => $feedback_form->id]) }}"><span class="cil-plus me-1"></span>Add form step</a>
            </div>
        </div>

        <table class="table table-bordered align-middle font-m">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Display Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedback_form->steps as $step)
                    <tr>
                        <td>{{ $step->title }}</td>
                        <td>{{ $step->order }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item font-m" href="{{ route('admin.events.feedback-form.steps.edit', ['event' => $event->id, 'feedback_form' => $step->id, 'step' => $step->id]) }}">Edit</a></li>
                                    @if(!$step->groups()->exists())
                                        <li><a class="dropdown-item font-m cursor-pointer" wire:confirm="Are you sure you want to delete this step?" wire:click.prevent="deleteStep({{ $step->id }})" ahref="">Delete</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No groups found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h4>Groups</h4>
            </div>
            <div class="col-sm-3">
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{ route('admin.events.feedback-form.groups.create', ['event' => $event->id, 'feedback_form' => $feedback_form->id]) }}"><span class="cil-plus me-1"></span>Add Question Group</a>
            </div>
        </div>

        <table class="table table-bordered align-middle font-m">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Step</th>
                    <th>Display Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedback_form->groups as $group)
                    <tr>
                        <td>{{ $group->title }}</td>
                        <td>{{ $group->step->title}}</td>
                        <td>{{ $group->order }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item font-m" href="{{ route('admin.events.feedback-form.groups.edit', ['event' => $event->id, 'feedback_form' => $feedback_form->id, 'group' => $group->id]) }}">Edit</a></li>
                                    <li><a class="dropdown-item font-m" href="{{ route('admin.events.feedback-form.questions.manage', ['event' => $event->id, 'feedback_form' => $feedback_form->id, 'group' => $group->id]) }}">Manage questions</a></li>
                                    @if(!$group->questions()->exists())
                                        <li><a class="dropdown-item font-m cursor-pointer" wire:confirm="Are you sure you want to delete this group?" wire:click.prevent="deleteGroup({{ $group->id }})" ahref="">Delete</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No groups found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>   
