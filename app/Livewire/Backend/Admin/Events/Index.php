<?php

namespace App\Livewire\Backend\Admin\Events;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Event;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormStep;
use App\Models\FeedbackFormGroup;
use App\Models\FeedbackFormQuestion;
use Illuminate\Support\Facades\DB;
use App\Services\EmailMarketing\EmailMarketingService;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter(string $filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function delete(int $id)
    {
        $event = Event::findOrFail($id);
        $event->update(['active' => false]);
        $event->delete();

        session()->flash('success', 'Event soft deleted successfully.');
    }

    public function duplicate(int $id)
    {
        DB::transaction(function () use ($id) {

            $event = Event::findOrFail($id);

            // 1) Duplicate event
            $newEvent = $event->replicate();
            $newEvent->title    = '[COPY] ' . $event->title;
            $newEvent->active   = false;
            $newEvent->template = false;
            $newEvent->save();

            $ticketGroupMap = [];
            foreach ($event->ticketGroups as $group) {
                $newGroup = $group->replicate();
                $newGroup->event_id = $newEvent->id;
                $newGroup->save();
                $ticketGroupMap[$group->id] = $newGroup->id;
            }

            foreach ($event->tickets as $ticket) {
                $data = $ticket->replicate()->toArray();
                $data['event_id']         = $newEvent->id;
                $data['ticket_group_id']  = $ticketGroupMap[$ticket->ticket_group_id] ?? null;
                $newEvent->tickets()->create($data);
            }

            // 3) Opt-in checks
            foreach ($event->eventOptInChecks as $optIn) {
                $newEvent->eventOptInChecks()->create($optIn->replicate()->toArray());
            }

            // 4) Payment methods
            foreach ($event->eventPaymentMethods as $method) {
                $newEvent->eventPaymentMethods()->create($method->replicate()->toArray());
            }

            // 5) Content
            foreach ($event->content as $content) {
                $data = $content->replicate()->toArray();
                $data['event_id'] = $newEvent->id;
                $newEvent->contentAll()->create($data);
            }

            // 5b) Event Session Groups → Sessions
            $sessionGroupMap = [];
            foreach ($event->eventSessionGroups as $group) {
                $newESG = $group->replicate();
                $newESG->event_id = $newEvent->id;
                $newESG->save();
                $sessionGroupMap[$group->id] = $newESG->id;
            }

            foreach ($event->eventSessionGroups as $group) {
                foreach ($group->sessions as $session) {
                    $newSession = $session->replicate();
                    $newSession->event_session_group_id = $sessionGroupMap[$group->id] ?? null;
                    $newSession->save();
                }
            }

            // 6) Feedback forms
            $forms = FeedbackForm::where('event_id', $event->id)
                ->with(['steps', 'groups', 'groups.questions', 'questions'])
                ->get();

            foreach ($forms as $form) {
                $newForm = $form->replicate();
                $newForm->event_id = $newEvent->id;
                $newForm->active = false;
                $newForm->save();

                // Steps
                $stepIdMap = [];
                foreach ($form->steps as $step) {
                    $newStep = $step->replicate();
                    $newStep->feedback_form_id = $newForm->id;
                    $newStep->save();
                    $stepIdMap[$step->id] = $newStep->id;
                }

                // Groups
                $groupIdMap = [];
                $origGroups = FeedbackFormGroup::where('feedback_form_id', $form->id)->orderBy('order')->get();

                foreach ($origGroups as $group) {
                    $newGroup = $group->replicate();
                    $newGroup->feedback_form_id = $newForm->id;
                    $newGroup->feedback_form_step_id = $stepIdMap[$group->feedback_form_step_id] ?? null;
                    $newGroup->save();
                    $groupIdMap[$group->id] = $newGroup->id;
                }

                // Questions
                $questionIdMap = [];
                $origQuestions = FeedbackFormQuestion::where('feedback_form_id', $form->id)->orderBy('order')->get();

                foreach ($origQuestions as $q) {
                    $newQ = $q->replicate();
                    $newQ->feedback_form_id = $newForm->id;
                    $newQ->feedback_form_group_id = $groupIdMap[$q->feedback_form_group_id] ?? null;

                    $oldVisibleRef = $q->visible_if_question_id;
                    $newQ->visible_if_question_id = null;
                    $newQ->save();

                    $questionIdMap[$q->id] = [$newQ->id, $oldVisibleRef];
                }

                // Deferred visibility linking
                foreach ($questionIdMap as $oldId => [$newId, $oldVisibleRef]) {
                    if ($oldVisibleRef && isset($questionIdMap[$oldVisibleRef])) {
                        $newVisibleId = $questionIdMap[$oldVisibleRef][0];
                        FeedbackFormQuestion::where('id', $newId)
                            ->update(['visible_if_question_id' => $newVisibleId]);
                    }
                }
            }

            // 7) Create new mailing list
            $emailService = app(EmailMarketingService::class);
            $listName = '[COPY]' . $event->title;
            $listId = $emailService->createMailingListInFolder(config('services.emailblaster.folder'), $listName);

            if ($listId) {
                $newEvent->update(['email_list_id' => $listId]);
            }

            session()->flash('success', 'Event duplicated successfully. Please rename the folder.');
        });
    }


    public function render()
    {
        $query = Event::query();

        $counts = [
            'all'      => Event::count(),
            'active'   => Event::where('active', 1)->count(),
            'inactive' => Event::where('active', 0)->count(),
            'template' => Event::where('template', 1)->count(),
            'archived' => Event::onlyTrashed()->count(),
        ];

        match ($this->filter) {
            'active'   => $query->where('active', 1),
            'inactive' => $query->where('active', 0),
            'template' => $query->where('template', 1),
            'archived' => $query->onlyTrashed(),
            default    => null,
        };

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('location', 'like', "%{$this->search}%");
            });
        }

        $events = $query->orderBy('date_start', 'desc')->paginate(20);

        return view('livewire.backend.admin.events.index', [
            'events' => $events,
            'counts' => $counts
        ]);
    }
}
