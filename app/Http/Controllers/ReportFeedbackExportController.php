<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormSubmission;
use App\Models\FeedbackFormResponse;
use App\Models\FeedbackFormQuestion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ReportFeedbackExportController extends Controller
{
    public function export(Event $event, FeedbackForm $feedback_form)
    {
        $submissions = FeedbackFormSubmission::query()
            ->where('feedback_form_id', $feedback_form->id)
            ->get();

        $submission_ids = $submissions->pluck('id');

        $responses = FeedbackFormResponse::query()
            ->where('feedback_form_id', $feedback_form->id)
            ->when($submission_ids->isNotEmpty(), fn($q) =>
                $q->whereIn('feedback_form_submission_id', $submission_ids)
            )
            ->get()
            ->groupBy('feedback_form_question_id');

        $questions = FeedbackFormQuestion::query()
            ->where('feedback_form_id', $feedback_form->id)
            ->orderBy('feedback_form_group_id')
            ->orderBy('order')
            ->get()
            ->groupBy('feedback_form_group_id');

        $totals = [
            'in_progress' => $feedback_form->submissions()->where('status', 'in_progress')->count(),
            'complete' => $feedback_form->submissions()->where('status', 'complete')->count(),
        ];
        $totals['completion_rate'] = $totals['complete'] > 0
            ? round(($totals['complete'] / ($totals['in_progress'] + $totals['complete'])) * 100, 1)
            : 0;

        // Report build
        $groups_report = [];

        foreach ($questions as $group_id => $group_questions) {
            $group_title = optional($group_questions->first()->group)->title ?? 'Other';

            $qs_out = [];
            foreach ($group_questions as $q) {
                $q_responses = $responses->get($q->id, collect());
                $item = [
                    'id' => $q->id,
                    'question' => $q->question,
                    'type' => $q->type,
                    'total_answers' => $q_responses->count(),
                    'labels' => [],
                    'counts' => [],
                    'percentages' => [],
                    'avg' => null,
                    'samples' => [],
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
                    $perc_out = [];
                    $denominator = max(1, $q_responses->count() ?: array_sum($counts_out) ?: 1);
                    foreach ($counts_out as $c) {
                        $perc_out[] = round(($c / $denominator) * 100);
                    }

                    $item['labels'] = $labels_out;
                    $item['counts'] = $counts_out;
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
                } else {
                    $samples = $q_responses->pluck('answer')->filter()->take(5)->values()->all();
                    $item['samples'] = $samples;
                }

                $qs_out[] = $item;
            }

            $groups_report[] = [
                'title' => $group_title,
                'questions' => $qs_out,
            ];
        }

        $report = [
            'form' => [
                'id' => $feedback_form->id,
                'title' => $feedback_form->title,
            ],
            'totals' => $totals,
            'groups' => $groups_report,
        ];

        // PDF export
        $pdf = Pdf::setOptions([
                'chroot' => base_path(),
                'isRemoteEnabled' => false,
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.reports.feedback-form.exports.pdf', [
                'event'      => $event,
                'report'      => $report,
                'exported_at' => Carbon::now('Europe/London')->format('d/m/Y H:i'),
                'brand_color' => '#142B54',
                'logo_path'   => resource_path('brand/logo.jpg'),
            ])
            ->setPaper('a4', 'portrait');

        return $pdf->download('feedback-report-'.$event->id.'-'.$feedback_form->id.'.pdf');
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
}
