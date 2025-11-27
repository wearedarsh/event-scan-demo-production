<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Profile</h2>
    </div>

    @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <span class="font-m">{{ $errors->first() }}</span>           
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <span class="font-m">{{ session('success') }}</span>           
                </div>
            </div>
        </div>
    @endif

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3 overflow-auto">
        <nav aria-label="breadcrumb" class="w-max">
            <ol class="breadcrumb d-flex flex-nowrap align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Edit Profile</h4>

            <form wire:submit.prevent="update" class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                        <select wire:model="title" class="form-control">
                        <option value="Dr">Dr</option>
                        <option value="Mr">Mr</option> 
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option> 
                        <option value="Ms">Ms</option> 
                        <option value="Professor">Professor</option> 
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input wire:model.live="first_name" type="text" class="form-control" id="first_name">
                </div>

                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input wire:model.live="last_name" type="text" class="form-control" id="last_name">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input wire:model.live="email" type="text" class="form-control" id="email">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Update Profile</button>
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-light">
                        <span class="text-brand-dark">Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>



</div>