<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedbackFormGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedback_form_id',
        'feedback_form_step_id',
        'title',
        'order',
    ];

    public function feedbackForm()
    {
        return $this->belongsTo(FeedbackForm::class);
    }

    public function step()
    {
        return $this->belongsTo(FeedbackFormStep::class, 'feedback_form_step_id');
    }


    public function questions()
    {
        return $this->hasMany(FeedbackFormQuestion::class)->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(FeedbackFormGroup::class, 'parent_group_id');
    }

    public function children()
    {
        return $this->hasMany(FeedbackFormGroup::class, 'parent_group_id')->orderBy('order');
    }
}
