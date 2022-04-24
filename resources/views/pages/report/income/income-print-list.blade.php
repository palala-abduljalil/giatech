<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIA TECH | Print Income List</title>
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
                    <h4>List of Incomes: {{ count($incomes) }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Project</th>
                                <th>Serivice</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Transaction Date</th>
                                <th>Transaction Encoded</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomes as $income)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $income->project->title }}</td>
                                <td>{{ $income->service }}</td>
                                <td>{{ $income->category->name }}</td>
                                <td>{{ $income->amount }}</td>
                                <td>{{ \Carbon\Carbon::parse($income->transactionDate)->toFormattedDateString() }}</td>
                                <td>{{ \Carbon\Carbon::parse($income->created_at)->toDayDateTimeString() }}</td>
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