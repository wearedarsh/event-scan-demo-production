<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Dashboard</h2>
    </div>

    <div class="col-12 me-2 mt-3">
        <div class="p-3 bg-body-tertiary border rounded-2">
            <div class="d-flex flex-row align-items-center">
                <h5>Welcome {{Auth::user()->title }} {{ Auth::user()->last_name }}</h5>
            </div>
            <p class="font-m">Please make a selection from the menu.</p>
            
        </div>
    </div>

</div>
