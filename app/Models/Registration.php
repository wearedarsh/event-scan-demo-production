<?php

namespace App\Models;

use App\Models\RegistrationTicket;
use App\Models\RegistrationDocument;
use App\Models\RegistrationOptInResponse;
use App\Models\RegistrationPayment;
use App\Models\Country;
use App\Models\EmailBroadcast;

use App\Models\User;
use App\Models\AttendeeType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Registration extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'event_id', 'title', 'first_name', 'last_name', 'address_line_one',
        'town', 'postcode', 'country_id', 'attendee_type_id', 'attendee_type_other',
        'mobile_country_code', 'mobile_number', 'email', 'status', 
        'payment_status', 'currently_held_position', 'booking_reference',
        'total_cents', 'special_requirements', 'email_subscriber_id', 'attendee_group_id'
    ];

    public function setAttendeeTypeIdAttribute($value)
    {   
        $this->attributes['attendee_type_id'] = $value === '' ? null : $value;
    }

    public function feedbackFormSubmissions()
    {
        return $this->hasMany(FeedbackFormSubmission::class, 'user_id', 'user_id');
    }

    public function scopeFeedbackCompleteForEvent($q, int $event_id)
    {
        return $q->whereHas('feedbackFormSubmissions', function ($s) use ($event_id) {
            $s->where('event_id', $event_id)->where('status', 'complete');
        });
    }

    public function scopeFeedbackIncompleteForEvent($q, int $event_id)
    {
        return $q->where(function ($query) use ($event_id) {
            $query
                ->whereDoesntHave('feedbackFormSubmissions', fn($sub) => $sub->where('event_id', $event_id))
                ->orWhereHas('feedbackFormSubmissions', fn($sub) => $sub
                    ->where('event_id', $event_id)
                    ->whereIn('status', ['started', 'in_progress'])
                );
        });
    }


    public function scopeWithTicket($q, $ticket_id)
    {
        return $q->whereHas('registrationTickets', fn($t) => $t->where('ticket_id', $ticket_id));
    }

    public function attendeeGroup()
    {
        return $this->belongsTo(AttendeeGroup::class, 'attendee_group_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function optInResponses()
    {
        return $this->hasMany(RegistrationOptInResponse::class);
    }

    public function emailBroadcasts(){
        return $this->hasMany(EmailBroadcast::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customFieldValues()
    {
        return $this->hasMany(RegistrationFormCustomFieldValue::class);
    }

    public function AttendeeType()
    {
        return $this->belongsTo(AttendeeType::class);
    }

    public function registrationTickets()
    {
        return $this->hasMany(RegistrationTicket::class);
    }

    public function getTotalCentsAttribute(): int
    {
        return $this->registrationTickets->sum(function ($ticket) {
            return $ticket->line_total_cents;
        });
    }

    public function getTotalAttribute(): string
    {
        return number_format($this->total_cents / 100, 2);
    }

    public function registrationDocuments()
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    public function payments()
    {
        return $this->hasMany(RegistrationPayment::class);
    }

    public function getFormattedPaidDateAttribute()
    {
        return Carbon::parse($this->paid_at)->format('d M Y H:i');
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class, 'attendee_id');
    }

    public function attendedSessions()
    {
        return $this->belongsToMany(EventSession::class, 'check_ins', 'attendee_id', 'event_session_id')
            ->withTimestamps();
    }

    public function getTotalCmePointsAttribute()
    {
        return (float) $this->attendedSessions()->sum('event_sessions.cme_points');
    }
}
