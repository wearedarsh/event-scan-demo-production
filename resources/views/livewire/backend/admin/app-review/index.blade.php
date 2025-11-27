<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Check in app review</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item active" aria-current="page">Check in app review</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3 mt-6">
            <div class="col-12">
                <h3>1. Initialise the app</h3>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">

                <p>Click this link on your device</p>
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{$initialise_url}}">Initialise app</a>
            </div>
        </div> 
    </div> 
                    <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3 mt-6">
            <div class="col-12">
                <h3>2. Scan succesful badge</h3>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                
                <p>This is succesful QR code for review</p>
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(150)->generate('success')) }}" width="200" height="200" />
            </div>
        </div>
        
    </div> 

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3 mt-6">
            <div class="col-12">
                <h3>3. Scan unsuccesful badge</h3>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <p>This is an unuccessful QR code for review</p>
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(150)->generate('fail')) }}" width="200" height="200" />
            </div>
        </div> 
    </div> 
    
