<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormStep;
use App\Models\FeedbackFormGroup;
use App\Models\FeedbackFormQuestion;

class MasterFeedbackFormSeeder extends Seeder
{
    public function run()
    {
        $form = FeedbackForm::updateOrCreate(
            ['title' => 'Event Feedback'],
            [
                'event_id' => 1,
                'active' => true,
                'is_anonymous' => true,
                'multi_step' => true,
                'number_of_steps' => 2,
            ]
        );

        $step1 = FeedbackFormStep::updateOrCreate(
            ['feedback_form_id' => $form->id, 'display_order' => 1],
            ['title' => 'Your Experience']
        );

        $step2 = FeedbackFormStep::updateOrCreate(
            ['feedback_form_id' => $form->id, 'display_order' => 2],
            ['title' => 'Event Impact']
        );


        $g1 = FeedbackFormGroup::updateOrCreate(
            ['feedback_form_id' => $form->id, 'title' => 'Overall Experience'],
            ['feedback_form_step_id' => $step1->id, 'display_order' => 1]
        );

        $g2 = FeedbackFormGroup::updateOrCreate(
            ['feedback_form_id' => $form->id, 'title' => 'Content & Delivery'],
            ['feedback_form_step_id' => $step1->id, 'display_order' => 2]
        );

        $g3 = FeedbackFormGroup::updateOrCreate(
            ['feedback_form_id' => $form->id, 'title' => 'Practical Application'],
            ['feedback_form_step_id' => $step2->id, 'display_order' => 1]
        );

        $g4 = FeedbackFormGroup::updateOrCreate(
            ['feedback_form_id' => $form->id, 'title' => 'Final Thoughts'],
            ['feedback_form_step_id' => $step2->id, 'display_order' => 2]
        );

        $this->addQuestion($g1,
            'How would you rate your overall experience at the event?',
            'radio',
            true,
            1,
            'Excellent, Good, Average, Poor'
        );

        $this->addQuestion($g1,
            'What did you enjoy most about the event?',
            'textarea',
            false,
            2
        );

        $this->addQuestion($g2,
            'How would you rate the quality of the content presented?',
            'radio',
            true,
            1,
            'Excellent, Good, Average, Poor'
        );

        $this->addQuestion($g2,
            'Was the information presented clearly and effectively?',
            'radio',
            true,
            2,
            'Yes, Mostly, Not really, No'
        );

        $impact = $this->addQuestion($g3,
            'Do you feel more confident applying what you learned?',
            'radio',
            true,
            1,
            'Yes, Somewhat, Not really, No'
        );

        $this->addQuestion($g3,
            'If not, what additional support or information would have been helpful?',
            'textarea',
            false,
            2,
            null,
            $impact?->id,
            'No'
        );

        $this->addQuestion($g4,
            'Would you recommend this event to a colleague?',
            'radio',
            true,
            1,
            'Yes, Maybe, No'
        );

        $this->addQuestion($g4,
            'Any final comments or suggestions?',
            'textarea',
            false,
            2
        );
    }

    private function addQuestion($group, $text, $type, $is_required, $display_order, $options_text = null, $visible_if_question_id = null, $visible_if_answer = null)
    {
        return FeedbackFormQuestion::updateOrCreate(
            [
                'feedback_form_group_id' => $group->id,
                'question' => $text,
            ],
            [
                'feedback_form_id' => $group->feedback_form_id,
                'type' => $type,
                'is_required' => $is_required,
                'display_order' => $display_order,
                'options_text' => $options_text,
                'visible_if_question_id' => $visible_if_question_id,
                'visible_if_answer' => $visible_if_answer,
            ]
        );
    }
}
