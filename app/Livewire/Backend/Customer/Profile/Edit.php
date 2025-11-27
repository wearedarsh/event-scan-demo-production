<?php

namespace App\Livewire\Backend\Customer\Profile;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Services\EmailMarketing\EmailMarketingService;

use App\Models\User;

#[Layout('livewire.backend.customer.layouts.app')]
class Edit extends Component
{
    public $title;
    public $first_name;
    public $last_name;
    public $email;
    public $user_id;
    public $user;

    public function rules()
    {
        return [
            'first_name' => 'nullable|string|max:20',
            'last_name' => 'nullable|string|max:20',
            'email' => [
                    'required', 
                    'email', 
                    function ($attribute, $value, $fail) {
                        $existingUser = User::where('email', $value)
                            ->where('active', true)
                            ->first();
                
                        if ($existingUser && $existingUser->id !== $this->user_id) {
                            $fail('That email is already registered to another account.');
                        }
                    }
                ],
        ];
    }


    public function update()
    {
        $this->validate();

        $data_array = [
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'title' => $this->title
        ];

        $emailService = app(EmailMarketingService::class);

        if($this->user->email_marketing_opt_in && $this->user->email_marketing_subscriber_id){
            $emailService->updateSubscriber($this->user->email_marketing_subscriber_id, $data_array);
        }

        foreach($this->user->registrations as $registration){
            if($registration->event->auto_email_opt_in && $registration->email_subscriber_id){
                $emailService->updateSubscriber($registration->email_subscriber_id, $data_array);
            }
        }

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email
        ]);

        activity('profile')
            ->causedBy($this->user)
            ->log('Updated profile');

        session()->flash('success', 'Your profile has been updated successfully.');
        return redirect()->route('customer.profile.edit', [
            'user' => $this->user_id,
        ]);
    }

    public function render()
    {
        return view('livewire.backend.customer.profile.edit', [
        ]);
    }

    public function mount(User $user){
        $this->user = $user;
        $this->title = $user->title;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->user_id = $user->id;
    }
}
