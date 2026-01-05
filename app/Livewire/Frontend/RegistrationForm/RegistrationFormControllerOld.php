<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Event;
use App\Models\AttendeeType;
use App\Models\Country;
use App\Models\User;
use App\Models\Registration;
use App\Models\Ticket;
use App\Models\RegistrationTicket;
use App\Models\RegistrationDocument;
use App\Models\RegistrationOptInResponse;
use App\Models\EventPaymentMethod;

use App\Mail\BankTransferInformationCustomer;
use App\Mail\BankTransferConfirmationAdmin;
use App\Mail\NoPaymentConfirmationCustomer;
use App\Mail\NoPaymentConfirmationAdmin;
use App\Mail\WelcomeEmailCustomer;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailService;

use App\Services\EmailMarketing\EmailMarketingService;

use Illuminate\Support\Facades\Log;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

use Illuminate\Support\Facades\Hash;

class RegistrationFormControllerOld extends Component
{
    protected EmailMarketingService $email_service;
    public Event $event;
    public $step = 1;
    public $page_title;
    public $countries;
    public $attendee_types;
    public $ticket_groups;
    public $cancelled = false;
    
    //Models ids
    public $registration_id = null;
    public $user_id = null;

    //Form values
    public $title, $first_name, $last_name, $address_line_one, $town, $postcode, $country_id;
    public $currently_held_position, $attendee_type_id, $attendee_type_other;
    public $mobile_country_code, $mobile_number, $email, $password, $password_confirmation;
    public $optin_third_party = false, $optin_photography = false, $optin_future_events = false;
    public $special_requirements;

    //Tickets
    public array $single_ticket_selections  = [];
    public array $ticket_quantities  = [];

    //Registration
    public float $registration_total = 0.00;
    public $currency_symbol;
    public array $registration_uploads = [];
    public $number_of_registrations;
    public $spaces_remaining;

    //Opt in
    public $email_marketing_opt_in = false;
    public array $opt_in_responses = [];

    //Email
    public bool $bankTransferEmailSent = false;


    //File uploads
    use WithFileUploads;

    //Hydration functions
    #[\Livewire\Attributes\On('hydrateRegistration')]
    public function hydrateRegistration($registration_id){
        $this->registration_id = $registration_id;

        $registration = Registration::find($this->registration_id);

        if(!$registration){
            $this->initialiseRegistrationModel();
        }else{
            $this->title = $registration->title;
            $this->first_name = $registration->first_name;
            $this->last_name = $registration->last_name;
            $this->address_line_one = $registration->address_line_one;
            $this->town = $registration->town;
            $this->postcode = $registration->postcode;
            $this->country_id = $registration->country_id;
            $this->currently_held_position = $registration->currently_held_position;
            $this->attendee_type_id = $registration->attendee_type_id;
            $this->attendee_type_other = $registration->attendee_type_other;
            $this->mobile_country_code = $registration->mobile_country_code;
            $this->mobile_number = $registration->mobile_number;
            $this->optin_third_party = $registration->optin_third_party;
            $this->optin_photography = $registration->optin_photography;
            $this->optin_future_events = $registration->optin_future_events;
            $this->special_requirements = $registration->special_requirements;
            
        }
    }

    #[\Livewire\Attributes\On('hydrateUser')]
    public function hydrateModels($user_id){
        $this->user_id = $user_id;

        $user = User::find($this->user_id);
        if($user){
            $this->email = $user->email;
        }
    }

    //Validation
    public function validateFormFields(){
        $this->resetErrorBag();
        if ($this->step === 1) {
            $this->validate([
                'title' => 'required',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address_line_one' => 'required|string|max:255',
                'town' => 'required|string|max:255',
                'postcode' => 'required|string|max:20',
                'country_id' => 'required',
            ],[
                'country_id.required' => 'Please select a country',
            ]);
        }

        if ($this->step === 2) {

            $medical_selected = AttendeeType::find($this->attendee_type_id);
            $is_other = optional($medical_selected)->isOther();
        
            $rules = [
                'currently_held_position' => 'required|string|max:255',
                'attendee_type_id' => 'required|exists:attendee_types,id',
            ];
        
            if ($is_other) {
                $rules['attendee_type_other'] = 'required|string|min:3';
            }
        
            $this->validate($rules, [
                'currently_held_position.required' => 'Please enter your company name', 
                'attendee_type.required' => 'Please select a profession from the list. If yours is not listed, enter it below.',
                'attendee_type_other.required' => 'If your profession is not listed, please enter it before moving on.',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'mobile_country_code' => [
                    'required',
                    'regex:/^\+\d{1,4}$/'
                ],
                'mobile_number' => [
                    'required',
                    'regex:/^[1-9]\d{6,14}$/'
                ],
                'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        $existingUser = User::where('email', $value)
                            ->where('active', true)
                            ->first();

                        if ($existingUser && $existingUser->id !== $this->user_id) {
                            $fail('That email is already registered to an active account.');
                        }
                    }
                ],
                'password' => 'required|min:8|confirmed',
            ], [
                'mobile_country_code.required' => 'Please enter your country code (e.g. +44).',
                'mobile_country_code.regex' => 'Country code must start with + and contain only digits.',
                'mobile_number.required' => 'Please enter your phone number.',
                'mobile_number.regex' => 'Please enter a valid phone number without a leading zero.',
            ]);
        }


        if ($this->step === 5) {

            $this->resetErrorBag();
        
            $required_group_errors = [];
        
            foreach ($this->event->ticketGroups->where('required', true) as $group) {
                $ticket_id = $this->single_ticket_selections[$group->id] ?? null;
        
                if (empty($ticket_id)) {
                    $required_group_errors["single_ticket_selections.{$group->id}"] = "Please select a ticket for '{$group->name}'.";
                }
        
                $selected_ticket = $group->tickets->firstWhere('id', $ticket_id);
                if ($selected_ticket && $selected_ticket->requires_document_upload) {
                    if (empty($this->registration_uploads[$group->id])) {
                        $required_group_errors["registration_uploads.{$group->id}"] = "Please upload a document for '{$group->name}'.";
                    }
                }
            }
        
            if (!empty($required_group_errors)) {
                foreach ($required_group_errors as $key => $message) {
                    $this->addError($key, $message);
                }
                return false;
            }
        }
        
    }

    //UPDATE METHODS
    public function updateRegistrationModel()
    {
        Registration::find($this->registration_id)->update([
            'title' => $this->title,
            'first_name' => ucfirst(strtolower($this->first_name)),
            'last_name' => ucfirst(strtolower($this->last_name)),
            'email' => $this->email,
            'address_line_one' => ucfirst(strtolower($this->address_line_one)),
            'town' => ucfirst(strtolower($this->town)),
            'postcode' => strtoupper($this->postcode),
            'country_id' => $this->country_id,
            'currently_held_position' => ucfirst(strtolower($this->currently_held_position)),
            'attendee_type_id' => $this->attendee_type_id,
            'attendee_type_other' => ucfirst(strtolower($this->attendee_type_other)) ?? null,
            'mobile_country_code' => $this->mobile_country_code,
            'mobile_number' => $this->mobile_number,
            'optin_third_party' => $this->optin_third_party,
            'optin_photography' => $this->optin_photography,
            'optin_future_events' => $this->optin_future_events,
            'special_requirements' => $this->special_requirements ?? null
        ]);
    }

    public function updateUserModel()
    {
        $user = User::find($this->user_id)->update([
            'title' => $this->title,
            'first_name' => ucfirst(strtolower($this->first_name)),
            'last_name' => ucfirst(strtolower($this->last_name)),
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'email_marketing_opt_in' => $this->email_marketing_opt_in
        ]);

    }
    
    //INITIALISE AND HYDRATE
    #[\Livewire\Attributes\On('initialiseRegistrationModel')]
    public function initialiseRegistrationModel()
    {
        $registration = Registration::create([
            'event_id' => $this->event->id,
            'payment_status' => 'pending',
            'is_complete' => false,
        ]);

        $this->registration_id = $registration->id;

        $this->dispatch('storeToLocalStorage', [
            'registration_id' => $this->registration_id
        ]);
    }

    public function initialiseUserModel()
    {
        $user = User::create([
            'first_name' => ucfirst(strtolower($this->first_name)),
            'last_name' => ucfirst(strtolower($this->last_name)),
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        $this->user_id = $user->id;

        $registration = Registration::find($this->registration_id)->update([
            'user_id' => $user->id
        ]);

        $this->dispatch('storeToLocalStorage', [
            'user_id' => $this->user_id
        ]);
    }

    public function boot(EmailMarketingService $email_service)
    {
        $this->email_service = $email_service;
    }


    public function mount(Event $event){

        //check registration is available before doing anything
        $this->event = $event;
        $this->spaces_remaining = $event->spaces_remaining;
        
        abort_unless($this->event->is_registerable, 403, 'Registration for this event is not available.');

        $this->event = $event;
        $this->countries = Country::where('active', true)->orderBy('name')->get();
        $this->attendee_types = AttendeeType::where('active', true)->get();
        $this->page_title = 'Event registration';
        $this->step = intval(request()->query('step', 1));
        $this->cancelled = request()->query('cancelled') === 'true';

        $this->currency_symbol = client_setting('general.currency_symbol');

        foreach ($this->event->eventOptInChecks as $check) {
            $this->opt_in_responses[$check->id] = false;
        }

    } 

    public function updated($property, $value){
        
        if($this->step === 5){
            $this->calculateRegistrationTotal();
        }
    }

    public function getRegistrationProperty()
    {
        return Registration::with(['event', 'user', 'AttendeeType', 'registrationTickets.ticket'])
            ->find($this->registration_id);
    }

    public function markRegistrationAsComplete(){
        $registration = Registration::find($this->registration_id)->update([
            'is_complete' => true
        ]);
    }


    public function prevStep(){

        if ($this->cancelled) {
            $this->cancelled = false;
        }

        if($this->user_id){
            $this->updateUserModel();
        }

        $this->updateRegistrationModel();

        $this->dispatch('stepChanged'); 
        $this->step--;
        
    }

    public function nextStep(){

        if ($this->cancelled) {
            $this->cancelled = false;
        }
        
        $validated = $this->validateFormFields();

        if ($validated === false || $this->getErrorBag()->isNotEmpty()) {
            $this->dispatch('scroll-to-top');
            return;
        }
        
        if($this->step === 3){
            if(!$this->user_id){
                $this->initialiseUserModel();
            }
        }

        if($this->step === 5){
            $this->syncRegistrationTickets();
            $this->syncDocumentUploads();
            $this->syncOptInResponses();
            $this->markRegistrationAsComplete();
        }

        if($this->user_id){
            $this->updateUserModel();
        }

        $this->updateRegistrationModel();
        $this->dispatch('scroll-to-top');
        $this->step++;
    }

    public function syncDocumentUploads()
    {

        RegistrationDocument::where('registration_id', $this->registration_id)->delete();
        
        foreach ($this->registration_uploads as $group_id => $file) {
            $ticket_id = $this->single_ticket_selections[$group_id] ?? null;


            if (!$ticket_id || !$file) {
                continue;
            }

            if ($file) {
                $original_name = $file->getClientOriginalName();
                $stored_path = $file->store('registration_documents', 'private');
        
                RegistrationDocument::create([
                    'registration_id' => $this->registration_id,
                    'ticket_id' => $ticket_id,
                    'file_path' => $stored_path,
                    'original_name' => $original_name,
                ]);
            }
        }

        $this->registration_uploads = []; 

    }

    public function syncOptInResponses()
    {
        foreach ($this->opt_in_responses as $check_id => $value) {
            RegistrationOptInResponse::updateOrCreate([
                'registration_id' => $this->registration_id,
                'event_opt_in_check_id' => $check_id,
            ], [
                'user_id' => $this->user_id,
                'value' => (bool) $value,
            ]);
        }
    }

    public function syncRegistrationTickets()
    {
        RegistrationTicket::where('registration_id', $this->registration_id)->delete();

        $ticket_prices = $this->getTicketPrices();

        foreach ($this->single_ticket_selections as $group_id => $ticket_id) {
            RegistrationTicket::create([
                'registration_id' => $this->registration_id,
                'ticket_id' => $ticket_id,
                'quantity' => 1,
                'price_at_purchase' => $ticket_prices[$ticket_id] ?? 0
            ]);
        }

        foreach ($this->ticket_quantities as $ticket_id => $qty) {
            if ($qty > 0) {
                RegistrationTicket::create([
                    'registration_id' => $this->registration_id,
                    'ticket_id' => $ticket_id,
                    'quantity' => $qty,
                    'price_at_purchase' => $ticket_prices[$ticket_id] ?? 0
                ]);
            }
        }
    }

    public function getTicketPrices()
    {
        $ticket_ids = collect($this->single_ticket_selections)
            ->values()
            ->merge(array_keys($this->ticket_quantities))
            ->unique()
            ->toArray();

        return Ticket::whereIn('id', $ticket_ids)->pluck('price', 'id');
    }

    public function calculateRegistrationTotal()
    {
        $total = 0.0;

        $ticket_prices = $this->getTicketPrices();

        foreach ($this->single_ticket_selections as $group_id => $ticket_id) {
            $total += $ticket_prices[$ticket_id] ?? 0;
        }

        foreach ($this->ticket_quantities as $ticket_id => $qty) {
            $total += ($ticket_prices[$ticket_id] ?? 0) * $qty;
        }

        $this->registration_total = $total;
    }

    public function noPaymentDue()
    {
        $registration = Registration::find($this->registration_id);
        $randomNumber = random_int(1000, 9999);
        $booking_reference = client_setting('general.invoice_prefix') . '-' . $randomNumber . '-' . $registration->user_id . '-' . $registration->event_id;
        
        $registration_total = 0;
        $registration->update([
            'payment_status' => 'paid',
            'event_payment_method_id' => EventPaymentMethod::where('payment_method', 'no_payment')->first()->id,
            'booking_reference' => $booking_reference,
            'payment_intent_id' => null,
            'registration_total' => $registration_total,
            'paid_at' => \Carbon\Carbon::now()
        ]);

        $registration->user->update([
            'active' => true
        ]);

        try{

            $mailable = new NoPaymentConfirmationCustomer($registration, $registration_total);

            EmailService::queueMailable(
                mailable: $mailable,
                recipient_user: $registration->user,
                recipient_email: $registration->email,
                friendly_name: 'No payment confirmation customer',
                type: 'transactional_customer',
                event_id: $registration->event_id,
            );

            Log::info('Customer confirmation email sent successfully.');
        }catch(\Throwable $e){
            Log::error('Error sending customer confirmation email: ' . $e->getMessage());
        }

        //Send customer welcome email
        $mailable = new WelcomeEmailCustomer($registration);

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_user: $registration->user,
            recipient_email: $registration->email,
            friendly_name: 'Welcome email customer',
            type: 'transactional_customer',
            event_id: $registration->event_id,
        );


        Log::info('Attempting to send admin No payment confirmation email to team members');

        try {

            foreach (User::adminNotificationRecipients() as $user) {

                $mailable = new NoPaymentConfirmationAdmin($registration, $registration_total);

                EmailService::queueMailable(
                    mailable: $mailable,
                    recipient_user: $user,
                    recipient_email: $user->email,
                    friendly_name: 'No payment confirmation admin',
                    type: 'transactional_admin',
                    event_id: $registration->event_id,
                );
            }

            Log::info('No payment confirmation admin email sent successfully.');

        } catch (\Throwable $e) {
            Log::error('Error sending admin email: ' . $e->getMessage());
        }

        if ($registration->event->auto_email_opt_in) {
            $email_subscriber_id = $this->email_service->addToList([
                'email' => $registration->email,
                'first_name' => $registration->user->first_name,
                'last_name' => $registration->user->last_name,
                'title' => $registration->user->title
            ], $registration->event->email_list_id);

            if($email_subscriber_id){
                $registration->update([
                    'email_subscriber_id' => $email_subscriber_id
                ]);
            }
        }

        if ($registration->user->email_marketing_opt_in) {
            $email_subscriber_id = $this->email_service->addToList([
                'email' => $registration->email,
                'first_name' => $registration->user->first_name,
                'last_name' => $registration->user->last_name,
                'title' => $registration->user->title
            ], config('services.emailblaster.marketing_list_id'));

            if($email_subscriber_id){
                $registration->user->update([
                    'email_marketing_subscriber_id' => $email_subscriber_id
                ]);
            }

        }   

        return redirect()->route('checkout.success', [
            'registration_id' => $registration->id,
            'event' => $registration->event,
        ]);
        
        
    }

    public function bankTransferPayment()
    {
        $registration = Registration::find($this->registration_id);

        $registration->update([
            'event_payment_method_id' => EventPaymentMethod::where('payment_method', 'bank_transfer')->first()->id,
            'registration_total' => $this->registration_total
        ]);

        if (!$this->bankTransferEmailSent) {

            $mailable = new BankTransferInformationCustomer($registration, $this->registration_total);

            EmailService::queueMailable(
                mailable: $mailable,
                recipient_user: $registration->user,
                recipient_email: $registration->email,
                friendly_name: 'Bank transfer information customer',
                type: 'transactional_customer',
                event_id: $registration->event_id,
            );
            Log::info('Bank transfer information email sent to customer');


            foreach (User::adminNotificationRecipients() as $user) {

                $mailable = new BankTransferConfirmationAdmin($registration, $this->registration_total);

                EmailService::queueMailable(
                    mailable: $mailable,
                    recipient_email: $user->email,
                    recipient_user: $user,
                    friendly_name: 'Bank transfer information admin',
                    type: 'transactional_admin',
                    event_id: $registration->event_id,
                );
            }
    
            $this->bankTransferEmailSent = true;
        }

        $this->step = 7;
    }


    public function clearLocalStorageAndRedirect(){
        $this->dispatch('removeFromLocalStorageAndRedirect');
    }

    public function stripePayment()
    {
        $registration = Registration::with('registrationTickets.ticket')->find($this->registration_id);

        $lineItems = $registration->registrationTickets->map(function ($regTicket) {
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $regTicket->ticket->name,
                    ],
                    'unit_amount' => $regTicket->price_at_purchase * 100,
                ],
                'quantity' => $regTicket->quantity,
            ];
        })->toArray();

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'success_url' => route('checkout.success', ['registration_id' => $registration->id, 'event' => $this->event]),
            'cancel_url' => route('registration', ['event' => $this->event->id]) . '?step=5&cancelled=true',
            'customer_email' => $registration->email,
            'metadata' => [
                'registration_id' => $registration->id,
            ]
        ]);

        return redirect($session->url);
    }

    public function render(){
        $this->number_of_registrations = Registration::where('event_id', $this->event->id)
                                        ->where('payment_status', 'paid')
                                        ->count();
        
        return view('livewire.frontend.registration-form')
            ->extends('livewire.frontend.layouts.app', [
                'event' =>$this->event,
                'spaces_remaining' => $this->spaces_remaining,
                'page_title' => $this->page_title

            ]);
    }
}

