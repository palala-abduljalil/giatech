<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIA TECH | Print Client List</title>
    <link rel="icon" href="{{ asset('/images/logo.jpg') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <style>
        small {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <section class="invoice">
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
                <div class="col-12">
                    <h4>List of Clients: {{ count($clients) }}</h4>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>E-Mail Address</th>
                                <th>Organization</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $client->fullName }}</td>
                                    <td>{{ $client->contactNumber->contactNumber }}</td>
                                    <td>{{ $client->emailAddress->emailAddress }}</td>
                                    <td>{{ $client->organization->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>