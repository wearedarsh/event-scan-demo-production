<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackFormResponse extends Model
{
    protected $fillable = [
        'feedback_form_id',
        'feedback_form_question_id',
        'feedback_form_submission_id',
        'answer',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(FeedbackForm::class, 'feedback_form_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(FeedbackFormQuestion::class, 'feedback_form_question_id');
    }

    public function submission()
    {
        return $this->belongsTo(FeedbackFormSubmission::class, 'feedback_form_submission_id');
    }
}
