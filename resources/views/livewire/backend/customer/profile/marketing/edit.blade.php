<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Marketing settings</h2>
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
                <li class="breadcrumb-item active" aria-current="page">Marketing settings</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Email marketing</h4>

            <form wire:submit.prevent="update" class="row g-3">
                <div class="col-12">
                    <label for="email_marketing_opt_in" class="form-label">Would you like to receive emails relating to future events and events?</label>
                </div>
                <div class="col-3 mb-3">
                        <select wire:model="email_marketing_opt_in" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option> 
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Update Settings</button>
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-light">
                        <span class="text-brand-dark">Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>



</div>