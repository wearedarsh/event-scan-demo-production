<?php 

namespace App\Livewire\Backend\Admin\Users;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $active = '';
    public ?int $role_id = null;

    public function save()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'role_id'    => 'required|exists:roles,id',
        ]);

        User::create([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'password'   => Hash::make($this->password),
            'role_id'    => $this->role_id,
            'active'     => (bool) $this->active,
            'is_admin'   => true
        ]);

        session()->flash('success', 'User created successfully.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.users.create', [
            'roles' => Role::get()
        ]);
    }
}

?>
