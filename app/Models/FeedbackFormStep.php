<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedbackFormStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedback_form_id',
        'title',
        'order',
    ];

    public function form()
    {
        return $this->belongsTo(FeedbackForm::class, 'feedback_form_id');
    }

    public function groups()
    {
        return $this->hasMany(FeedbackFormGroup::class);
    }
}
