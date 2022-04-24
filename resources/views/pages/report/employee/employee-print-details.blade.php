<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIA TECH - {{ $employee->fullName }}</title>
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
                        
                        <h2>{{ $employee->fullName }}</h2>
                        <div class="">
                            {{ $employee->address->fullAddress }}
                        </div>
                        <div class="">
                            <span class="font-weight-bold">Contact Number:</span> {{ $employee->contactNumber->contactNumber}}
                        </div>
                        <div class="">
                            <span class="font-weight-bold">Email Address:</span> {{ $employee->emailAddress->businessEmail }}
                        </div>
                        
                        {{-- <small class="float-right">Date: {{ Carbon\Carbon::now()->format('m/d/Y') }}</small> --}}
                    </h2>
                </div>
                <div class="col-4">
                    <img src="{{ $employee->profilePicture }}" width="150px" height="150px" class="float-right"
                        alt="">
                </div>
                
            </div>
            <hr />
            
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 font-weight-bold">Name</div>
                        <div class="col-6">{{ $employee->fullName }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Address</div>
                        <div class="col-6">{{ $employee->address->fullAddress}}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Employee Number</div>
                        <div class="col-6">{{ $employee->employeeNumber }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Date Hired</div>
                        <div class="col-6">{{ $employee->dateHired }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Business E-Mail</div>
                        <div class="col-6">{{ $employee->emailAddress->businessEmail }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Alternate E-Mail</div>
                        <div class="col-6">{{ $employee->emailAddress->alternateEmail }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Contact Number</div>
                        <div class="col-6">{{ $employee->contactNumber->contactNumber }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Position</div>
                        <div class="col-6">{{ $employee->position->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Department</div>
                        <div class="col-6">{{ $employee->department->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Status</div>
                        <div class="col-6">{{ $employee->status->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Degree</div>
                        <div class="col-6">{{ $employee->degree->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">Year Graduated</div>
                        <div class="col-6">{{ $employee->yearGraduated }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6 font-weight-bold">School</div>
                        <div class="col-6">{{ $employee->school->name }}</div>
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