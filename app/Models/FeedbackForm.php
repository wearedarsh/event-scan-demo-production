<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FeedbackFormQuestion;
use App\Models\FeedbackFormGroup;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackForm extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'event_id', 'active', 'is_anonymous', 'multi_step', 'number_of_steps'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function steps()
    {
        return $this->hasMany(FeedbackFormStep::class)->orderBy('display_order');
    }

    public function questions()
    {
        return $this->hasMany(FeedbackFormQuestion::class)->orderBy('display_order');
    }

    public function groups()
    {
        return $this->hasMany(FeedbackFormGroup::class);
    }

    public function submissions()
    {
        return $this->hasMany(FeedbackFormSubmission::class);
    }
}
