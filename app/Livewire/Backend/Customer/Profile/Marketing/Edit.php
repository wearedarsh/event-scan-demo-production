<?php

namespace App\Livewire\Backend\Customer\Profile\Marketing;
use App\Services\EmailMarketing\EmailMarketingService;
use App\Models\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.customer.layouts.app')]
class Edit extends Component
{
    public User $user;
    public int $email_marketing_opt_in;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->email_marketing_opt_in = $user->email_marketing_opt_in;
    }

    public function render()
    {
        return view('livewire.backend.customer.profile.marketing.edit');
    }

    public function update()
    {
        $attendee_array = [
            'email' => $this->user->email,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'title' => $this->user->title
        ];

        $emailService = app(EmailMarketingService::class);

        if (!$this->user->email_marketing_opt_in) {

            $email_subscriber_id = $emailService->addToList($attendee_array, config('services.emailblaster.marketing_list_id'));

            $this->user->update([
                'email_marketing_opt_in' => true,
                'email_marketing_subscriber_id' => $email_subscriber_id
            ]);

            activity('marketing')
                ->causedBy($this->user)
                ->log('Opted in to future email marketing');

            session()->flash('success', 'You have been added to the email marketing list');


        } else {

            $emailService->removeFromList($this->user->email_marketing_subscriber_id, config('services.emailblaster.marketing_list_id'));

            $this->user->update([
                'email_marketing_opt_in' => false,
                'email_marketing_subscriber_id' => null
            ]);

            activity('marketing')
                ->causedBy($this->user)
                ->log('Opted out of future email marketing');

            session()->flash('success', 'You have been removed from the email marketing list');

        }
    }
}
