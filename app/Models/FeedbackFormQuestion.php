<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackFormQuestion extends Model
{
    protected $fillable = [
        'feedback_form_id',
        'question',
        'type',
        'feedback_form_group_id',
        'order',
        'is_required',
        'options_text',
        'visible_if_question_id',
        'visible_if_answer'
    ];

    public function form()
    {
        return $this->belongsTo(FeedbackForm::class);
    }

    public function group()
    {
        return $this->belongsTo(FeedbackFormGroup::class, 'feedback_form_group_id');
    }

    public function responses()
    {
        return $this->hasMany(FeedbackFormResponse::class);
    }
}
