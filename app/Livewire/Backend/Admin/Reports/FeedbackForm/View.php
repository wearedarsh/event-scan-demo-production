<?php

namespace App\Livewire\Backend\Admin\Reports\FeedbackForm;

use App\Models\Event;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormQuestion;
use App\Models\FeedbackFormResponse;
use App\Models\FeedbackFormSubmission;
use App\Models\FeedbackFormGroup;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class View extends Component
{
	public Event $event;
	public FeedbackForm $feedback_form;

	public string $date_from = '';
	public string $date_to = '';

	public array $report = [];
	public array $charts = [];

	public function mount(Event $event, FeedbackForm $feedback_form)
	{
		$this->event = $event;
		$this->feedback_form = $feedback_form;
		$this->buildReport();
	}

	public function updated($prop)
	{
		if (in_array($prop, ['date_from','date_to'])) {
			$this->buildReport();
		}
	}

	protected function buildReport(): void
    {
        $submissions = FeedbackFormSubmission::query()
            ->where('feedback_form_id', $this->feedback_form->id)
            ->when($this->date_from, fn($q)=>$q->whereDate('submitted_at','>=',$this->date_from))
            ->when($this->date_to, fn($q)=>$q->whereDate('submitted_at','<=',$this->date_to))
            ->get();

        $submission_ids = $submissions->pluck('id');

        $responses = FeedbackFormResponse::query()
            ->where('feedback_form_id', $this->feedback_form->id)
            ->when($submission_ids->isNotEmpty(), fn($q)=>$q->whereIn('feedback_form_submission_id', $submission_ids))
            ->get()
            ->groupBy('feedback_form_question_id');

        $totals = [
            'in_progress' => $this->feedback_form->submissions()->where('status', 'in_progress')->count(),
            'complete'    => $this->feedback_form->submissions()->where('status', 'complete')->count(),
        ];
        $totals['completion_rate'] = $totals['complete'] > 0
            ? round(($totals['complete'] / max(1, ($totals['in_progress'] + $totals['complete'])))*100, 1)
            : 0;
        $totals['date_from'] = $this->date_from;
        $totals['date_to']   = $this->date_to;

        // Load groups + questions (ordered)
        $groups = FeedbackFormGroup::query()
            ->where('feedback_form_id', $this->feedback_form->id)
            ->orderBy('order')
            ->with(['questions' => function($q){
                $q->orderBy('order');
            }])
            ->get();

        // Find any ungrouped questions
        $ungroupedQuestions = FeedbackFormQuestion::query()
            ->where('feedback_form_id', $this->feedback_form->id)
            ->whereNull('feedback_form_group_id')
            ->orderBy('order')
            ->get();

        $groups_report = [];
        $charts = [];

        // Helper to build a question item
        $makeItem = function(FeedbackFormQuestion $q) use ($responses, &$charts) {
            $q_responses = $responses->get($q->id, collect());
            $item = [
                'id'            => $q->id,
                'question'      => $q->question,
                'type'          => $q->type,
                'total_answers' => $q_responses->count(),
                'labels'        => [],
                'counts'        => [],
                'percentages'   => [],
                'avg'           => null,
                'samples'       => [],
            ];

            $options = $this->parseOptions($q->options_text);
            $is_option_based = in_array($q->type, ['radio','select','checkbox','multi-select']) || (!empty($options));

            if ($is_option_based) {
                $labels = $options ?: $this->inferLabelsFromAnswers($q_responses);
                $count_map = array_fill_keys($labels, 0);

                foreach ($q_responses as $r) {
                    $ans = trim((string)$r->answer);
                    if ($q->type === 'checkbox' || $q->type === 'multi-select') {
                        $parts = array_map('trim', array_filter(explode(',', $ans)));
                        foreach ($parts as $p) {
                            if (!array_key_exists($p, $count_map)) $count_map[$p] = 0;
                            $count_map[$p]++;
                        }
                    } else {
                        if (!array_key_exists($ans, $count_map)) $count_map[$ans] = 0;
                        if ($ans !== '') $count_map[$ans]++;
                    }
                }

                $labels_out = array_values(array_keys($count_map));
                $counts_out = array_values($count_map);
                $perc_out   = [];
                $denominator = max(1, $q_responses->count() ?: array_sum($counts_out) ?: 1);
                foreach ($counts_out as $c) {
                    $perc_out[] = round(($c / $denominator) * 100);
                }

                $item['labels']      = $labels_out;
                $item['counts']      = $counts_out;
                $item['percentages'] = $perc_out;

                $maybe_numeric = $this->mapLabelsToLikert($labels_out);
                if ($maybe_numeric) {
                    $sum = 0; $n = 0;
                    foreach ($q_responses as $r) {
                        $val = $maybe_numeric[$r->answer] ?? null;
                        if ($val !== null) { $sum += $val; $n++; }
                    }
                    $item['avg'] = $n ? round($sum / $n, 2) : null;
                }

                $type = in_array($q->type, ['checkbox','multi-select']) ? 'bar' : (count($labels_out) > 5 ? 'bar' : 'pie');
                $charts[] = [
                    'question_id' => $q->id,
                    'type'        => $type,
                    'labels'      => $labels_out,
                    'data'        => $counts_out,
                ];

            } else {
                $samples = $q_responses->pluck('answer')->filter()->values()->all();
                $item['samples'] = $samples;
            }

            return $item;
        };

        foreach ($groups as $g) {
            $groupBlock = [
                'title'     => $g->title,
                'order'     => $g->order,
                'questions' => [],
            ];
            foreach ($g->questions as $q) {
                $groupBlock['questions'][] = $makeItem($q);
            }
            $groups_report[] = $groupBlock;
        }

        if ($ungroupedQuestions->isNotEmpty()) {
            $ug = [
                'title'     => 'Other questions',
                'order'     => 9999,
                'questions' => [],
            ];
            foreach ($ungroupedQuestions as $q) {
                $ug['questions'][] = $makeItem($q);
            }
            $groups_report[] = $ug;
        }

        usort($groups_report, fn($a,$b)=> ($a['order'] <=> $b['order']) ?: strcmp($a['title'], $b['title']));

        $this->report = [
            'form'  => ['id' => $this->feedback_form->id, 'title' => $this->feedback_form->title],
            'totals'=> $totals,
            'groups'=> $groups_report,
        ];
        $this->charts = $charts;
    }

	protected function parseOptions(?string $options_text): array
	{
		if (!$options_text) return [];
		$parts = array_map('trim', array_filter(explode(',', $options_text)));
		return array_values(array_unique($parts));
	}

	protected function inferLabelsFromAnswers(Collection $responses): array
	{
		$vals = $responses->pluck('answer')->filter()->map(fn($v)=>trim((string)$v))->unique()->values()->all();
		return $vals ?: [];
	}

	protected function mapLabelsToLikert(array $labels): ?array
	{
		$map = [
			'Extremely useful' => 5,
			'Very useful' => 4,
			'Useful' => 4,
			'Fairly useful' => 3,
			'Neutral' => 3,
			'Undecided' => 3,
			'Undecided/DNA' => 3,
			'Not useful' => 2,
			'Poor' => 2,
			'Very poor' => 1,
		];
		$out = [];
		foreach ($labels as $l) {
			if (!array_key_exists($l, $map)) return null;
			$out[$l] = $map[$l];
		}
		return $out;
	}

	public function render()
	{
		return view('livewire.backend.admin.reports.feedback-form.view');
	}
}
