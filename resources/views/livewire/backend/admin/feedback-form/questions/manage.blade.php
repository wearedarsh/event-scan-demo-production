<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Manage questions<br><span class="font-m">{{ $group->title }}</span></h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{$event->title}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.feedback-form.index', $event->id) }}">Feedback forms</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.feedback-form.manage', [$event->id, $feedback_form->id]) }}">{{$feedback_form->title}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage questions</li>
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

<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3 mb-5">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h4>Questions</h4>
            </div>
            <div class="col-sm-3">
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{ route('admin.events.feedback-form.questions.create', ['event' => $event->id, 'feedback_form' => $feedback_form->id, 'group' => $group->id]) }}"><span class="cil-plus me-1"></span>Add Question</a>
            </div>
        </div>

        <table class="table table-bordered align-middle font-m">
            <thead class="table-light">
                <tr>
                    <th>Question</th>
                    <th>Group</th>
                    <th>Type</th>
                    <th>Display Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($group->questions as $question)
                    <tr>
                        <td>@if($question->visible_if_question_id) <span class="badge text-bg-success font-m"><span class="font-s text-white fw-normal">Optional</span></span>  @endif {{ $question->question }}</td>
                        <td>{{ $question->group->title }}</td>
                        <td>{{ $question->type }}</td>
                        <td>{{ $question->order }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item font-m" href="{{ route('admin.events.feedback-form.questions.edit', ['event' => $event->id, 'feedback_form' => $feedback_form->id, 'group' => $group->id, 'question' => $question->id]) }}">Edit</a></li>
                                    @if($question->responses->isEmpty())
                                    <li><a class="dropdown-item font-m cursor-pointer" wire:confirm="Are you sure you want to delete this question?" wire:click.prevent="deleteQuestion({{ $question->id }})" ahref="">Delete</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No questions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>