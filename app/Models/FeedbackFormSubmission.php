<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedbackFormSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'feedback_form_id',
        'submitted_at',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function responses(): HasMany 
    {
        return $this->hasMany(FeedbackFormResponse::class);
    }

    public function feedbackForm(): BelongsTo
    {
        return $this->belongsTo(FeedbackForm::class);
    }
}
