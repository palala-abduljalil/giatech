<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIA TECH - {{ $client->fullName }}</title>
    <link rel="icon" href="{{ asset('/images/logo.jpg') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <style>
        .wrapper {
            margin-right: 120px;
            margin-left: 120px;
        }
        small {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <section class="">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="page-header">
                        <img src="{{ asset('images/logo.jpg') }}" width="50px"> GIA TECH IT SOLUTIONS
                        {{-- <img src="{{ asset('images/login-logo.png') }}" width="20%" class="img-fluid"
                        alt=""> --}}
                        <small class="float-right">Date: {{ Carbon\Carbon::now()->format('m/d/Y') }}</small>
                    </h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-8">
                    <h2 class="page-header">
                        
                        <h2>{{ $client->fullName }}</h2>
                        <div class="">
                            {{ $client->address->fullAddress }}
                        </div>
                        <div class="">
                            <span class="font-weight-bold">Contact Number:</span> {{ $client->contactNumber->contactNumber}}
                        </div>
                        <div class="">
                            <span class="font-weight-bold">Email Address:</span> {{ $client->emailAddress->emailAddress }}
                        </div>
                    </h2>
                </div>
                <div class="col-4">
                    <img src="{{ $client->profilePicture }}" width="150px" height="150px" class="float-right"
                        alt="">
                </div>
                
            </div>
            <hr />
            
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 font-weight-bold">Name</div>
                        <div class="col-6">{{ $client->fullName }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Address</div>
                        <div class="col-6">{{ $client->address->fullAddress}}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">E-Mail Address</div>
                        <div class="col-6">{{ $client->emailAddress->emailAddress }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Contact Number</div>
                        <div class="col-6">{{ $client->contactNumber->contactNumber }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Organization</div>
                        <div class="col-6">{{ $client->organization->name }}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>