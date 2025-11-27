<?php

namespace App\Livewire\Backend\Admin\Users;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public User $user;

    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public ?int $role_id = null;
    public string $active = '0';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->active = $user->active;
    }

    public function update()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)],
            'role_id'    => 'required|exists:roles,id',
        ]);

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'role_id'    => $this->role_id,
            'active'     => (bool) $this->active,
        ]);

        session()->flash('success', 'User updated successfully.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.users.edit', [
            'roles' => \App\Models\Role::get()
        ]);
    }
}
