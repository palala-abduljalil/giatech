<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIA TECH | Print Project's Activities List</title>
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
                        <small class="float-right">Date: {{ Carbon\Carbon::now()->format('m/d/Y') }}</small>
                    </h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <h4>List of Activities by {{ $project }}: {{ count($activities) }}</h4>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $activity->description }}</td>
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