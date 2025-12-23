<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Ticket;
use App\Models\TicketGroup;
use App\Models\EventContent;
use App\Models\EventDownload;
use App\Models\EventOptInCheck;
use App\Models\EventPaymentMethod;
use App\Models\AttendeeGroup;
use App\Models\Registration;
use App\Models\FeedbackForm;
use App\Models\RegistrationForm;

class Event extends Model

{
    use SoftDeletes;
    protected $fillable = [
        'id','event_id', 'title', 
        'location', 'date_start', 'date_end', 
        'event_attendee_limit', 'vat_percentage', 
        'full', 'provisional', 'active', 
        'registration_type'];

    protected $appends = ['formatted_start_date', 'formatted_end_date'];
    
    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class)->where('payment_status', '!=', 'paid')->whereNotNull('event_payment_method_id')->where('is_complete', true);
    }

    public function registrationForm()
    {
        return $this->belongsTo(RegistrationForm::class);
    }

    public function attendees()
    {
        return $this->hasMany(Registration::class)->where('payment_status', 'paid')->orderBy('paid_at', 'asc');
    }

    public function attendeeGroups()
    {
        return $this->hasMany(AttendeeGroup::class);
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class)->where('active', true);
    }

    public function feedbackFormsActive()
    {
        return $this->hasMany(FeedbackForm::class)->where('active', true);
    }

    public function personnelGroups()
    {
        return $this->hasMany(PersonnelGroup::class);
    }

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }

    public function feedbackFormsAll()
    {
        return $this->hasMany(FeedbackForm::class);
    }

    public function allTicketGroups()
    {
        return $this->hasMany(TicketGroup::class);
    }

    public function allTickets()
    {
        return $this->hasMany(Ticket::class)->orderBy('ticket_group_id', 'asc');
    }

    public function eventOptInChecks()
    {
        return $this->hasMany(EventOptInCheck::class);
    }

    public function emailBroadcasts()
    {
        return $this->hasMany(EmailBroadcast::class);
    }

    public function eventPaymentMethods()
    {
        return $this->hasMany(EventPaymentMethod::class)->where('enabled', true);
    }

    public function frontendTickets()
    {
        return $this->hasMany(Ticket::class)->where('active', true)->where('display_front_end', true);
    }

    public function ticketGroups()
    {
        return $this->hasMany(TicketGroup::class)->where('active', true);
    }

    public function content()
    {
        return $this->hasMany(EventContent::class)->where('active', true);
    }

    public function contentAll()
    {
        return $this->hasMany(EventContent::class)->orderBy('order', 'asc');
    }

    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->date_start)->format('d M Y');
    }

    public function getFormattedEndDateAttribute()
    {
        return Carbon::parse($this->date_end)->format('d M Y');
    }

    public function downloads()
    {
        return $this->hasMany(EventDownload::class)->where('active', true);
    }

    public function flyers()
    {
        return $this->hasMany(EventFlyer::class);
    }

    public function eventSessionGroups()
    {
        return $this->hasMany(EventSessionGroup::class);
    }

    public function getSpacesRemainingAttribute()
    {
        $registrations = Registration::where('event_id', $this->id)
            ->where('payment_status', 'paid')
            ->count();

        return max(0, $this->event_attendee_limit - $registrations);
    }

    public function getIsRegisterableAttribute()
    {
        return $this->active
            && !$this->full
            && $this->spaces_remaining > 0
            && (!$this->date_end || Carbon::now()->lt($this->date_end))
            && (!$this->provisional);
    }
}
