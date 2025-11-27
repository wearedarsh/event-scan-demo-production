<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormStep;
use App\Models\FeedbackFormGroup;
use App\Models\FeedbackFormQuestion;

class FeedbackFormFullSeeder extends Seeder
{
    public function run()
    {
        $form = FeedbackForm::updateOrCreate(
            ['title' => 'EACCME® participant’s evaluation form'],
            ['event_id' => 1, 'active' => false, 'is_anonymous' => true, 'multi_step' => true, 'number_of_steps' => 5]
        );

        $stepModels = [];
        foreach (range(1, 7) as $order) {
            $stepModels[$order] = FeedbackFormStep::updateOrCreate([
                'feedback_form_id' => $form->id,
                'order' => $order,
            ], [
                'title' => 'Step ' . $order,
            ]);
        }

        $groupsData = [
            'Quality of the event' => 1,
            'What was your overall impression of this event?' => 2,
            'Relevance of the event' => 3,
            'How useful to you personally was each session?' => 4,
            'Suitability of formats used during the event' => 5,
            'Ways the event affects clinical practice' => 6,
            'Commercial bias' => 7,
        ];

        $groups = [];
        foreach ($groupsData as $title => $step) {
            $groups[$title] = FeedbackFormGroup::updateOrCreate([
                'feedback_form_id' => $form->id,
                'title' => $title,
            ], [
                'feedback_form_step_id' => $stepModels[$step]->id,
                'order' => $step,
            ]);
        }

        $usefulnessQuestion = $this->addQuestion(
            $groups['Quality of the event'],
            'How useful for your professional activity did you find this event?',
            'radio',
            true,
            1,
            'Extremely useful, Useful, Fairly useful, Not useful'
        );

        $this->addQuestion(
            $groups['Quality of the event'],
            'If this activity was not useful, please explain why:',
            'textarea',
            true,
            2,
            null,
            $usefulnessQuestion?->id,
            'Not useful'
        );

        $this->addQuestion($groups['What was your overall impression of this event?'], 'Programme', 'radio', true, 4, 'Excellent, Good, Fairly good, Poor, Very poor');
        $this->addQuestion($groups['What was your overall impression of this event?'], 'Organisation', 'radio', true, 5, 'Excellent, Good, Fairly good, Poor, Very poor');
        $this->addQuestion($groups['What was your overall impression of this event?'], 'What was the best aspect of this event?', 'textarea', true, 6);
        $this->addQuestion($groups['What was your overall impression of this event?'], 'What was the worst aspect of this event?', 'textarea', true, 7);

        $this->addQuestion($groups['Relevance of the event'], 'Did the event fulfil your educational goals and expected learning outcomes?', 'radio', true, 1, 'Very much, Somewhat, Not much, Not at all, Undecided');
        $this->addQuestion($groups['Relevance of the event'], 'Was the presented information well balanced and consistently supported by a valid scientific evidence base?', 'radio', true, 2, 'Very much, Somewhat, Not much, Not at all, Undecided');

        $sessions = [
            'Chronic Venous Disease',
            'Video: Deep Venous',
            'Non-invasive treatment of CVD',
            'Primary Superficial incompetence',
            'Video: Superficial',
            'Prevention and Management of venous thromboembolism',
            'Diagnosis and treatment of chronic venous insufficiency (C3-C6)',
            'Diagnosis and treatment of lymphoedema',
            'Workshops:',
            'Intermittent compression device',
            'Mechano-chemical ablation',
            'RF Ablation',
            'Compression therapy',
            'Venoactive drugs',
            'Laser ablation',
            'Foam sclerotherapy',
            'IVUS',
            'Stenting',
            'Superficial/Pelvic vein incompetence',
            'Mechanical thrombectomy',
            'Venous medical adhesive stocking',
            'Thrombolysis/Stent',
            'Mini-phlebectomy',
            'Ultrasound – Recurrent varicose veins',
            'Ultrasound – Abdominal and pelvic',
            'Ultrasound - Superficial incompetence',
            'Ultrasound - Deep venous obstruction',
        ];

        foreach ($sessions as $index => $title) {
            $this->addQuestion($groups['How useful to you personally was each session?'], $title, 'radio', true, $index + 1, 'Extremely useful, Useful, Fairly useful, Not useful, Undecided/DNA');
        }

        $this->addQuestion($groups['Suitability of formats used during the event'], 'Was there adequate time available for discussions, questions & answers and learner engagement?', 'radio', true, 1, 'Always, Sometimes, Only rarely, Never, Undecided');
        $this->addQuestion($groups['Suitability of formats used during the event'], 'Can you indicate any innovative elements during the activity?', 'textarea', true, 2);

        $this->addQuestion($groups['Ways the event affects clinical practice'], 'Will the information you learnt be implemented in your practice?', 'radio', true, 1, 'Very much, Somewhat, Not much, Not at all, Undecided');
        $this->addQuestion($groups['Ways the event affects clinical practice'], 'Can you provide ONE example how this event will influence your future practice?', 'textarea', true, 2);

        $this->addQuestion($groups['Commercial bias'], 'Did all the faculty members provide their potential conflict of interest declaration with the sponsor(s) as a second slide of their presentation?', 'radio', true, 1, 'Yes - all, Yes - for the the majority, Yes - but only a small part, No, Undecided/don’t know');
        $this->addQuestion($groups['Commercial bias'], 'Can you provide an example of biased presentation in this activity?', 'textarea', true, 2);
        $this->addQuestion($groups['Commercial bias'], 'Do you agree that the information was overall free of commercial and other bias?', 'radio', true, 3, 'Strongly agree, Rather agree, Rather disagree, Strongly disagree, Undecided/don’t know');
    }

    private function addQuestion($group, $text, $type, $is_required, $order, $options_text = null, $visible_if_question_id = null, $visible_if_answer = null)
    {
        return FeedbackFormQuestion::updateOrCreate([
            'feedback_form_group_id' => $group->id,
            'question' => $text,
        ], [
            'feedback_form_id' => $group->feedback_form_id,
            'type' => $type,
            'is_required' => $is_required,
            'order' => $order,
            'options_text' => $options_text,
            'visible_if_question_id' => $visible_if_question_id,
            'visible_if_answer' => $visible_if_answer,
        ]);
    }
}
