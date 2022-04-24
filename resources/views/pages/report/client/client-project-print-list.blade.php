<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIA TECH | Print Client's Project List</title>
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
                    <h4>List of Projects by {{ $client }}: {{ count($projects) }}</h4>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->category->name }}</td>
                                    <td>{{ $project->status->name }}</td>
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