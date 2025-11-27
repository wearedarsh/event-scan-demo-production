<?php

namespace App\Livewire\Backend\Admin\Users;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Mail\CheckInAppInviteAdmin;
use App\Mail\CheckInAppInstructionAdmin;
use App\Services\EmailService;
use Illuminate\Support\Facades\Password;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = 'all';

    protected $queryString = [
        'search'     => ['except' => ''],
        'roleFilter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setRoleFilter(string $filter)
    {
        $this->roleFilter = $filter;
        $this->resetPage();
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['active' => false]);
        $user->delete();

        session()->flash('success', 'User soft deleted successfully.');
    }

    public function sendInvite(int $user_id, bool $is_app_user)
    {
        $user = User::findOrFail($user_id);

        $token = Password::broker()->createToken($user);
        $reset_url = url(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ], false));

        if ($is_app_user) {
            $mailable = new CheckInAppInviteAdmin($user, $reset_url);
            $friendly_name = 'App invite to app user';
            $success_message = 'App invite sent to user';
        } else {
            $mailable = new CheckInAppInstructionAdmin($user);
            $friendly_name = 'App instuctions sent to admin user';
            $success_message = 'App instructions sent to user';
        }

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_email: $user->email,
            recipient_user: $user,
            friendly_name: $friendly_name,
            type: 'Admin triggered',
            event_id: null,
        );

        session()->flash('success', $success_message);
    }

    public function render()
    {
        $query = User::query()
            ->where('is_admin', true)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
                });
            })

            // ---- ROLE FILTER LOGIC ----
            ->when($this->roleFilter !== 'all', function ($q) {
                $q->whereHas('role', function ($q) {
                    $q->where('key_name', $this->roleFilter);
                });
            });

        $users = $query->paginate(10);

        return view('livewire.backend.admin.users.index', [
            'users' => $users
        ]);
    }
}
