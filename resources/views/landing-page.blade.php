<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/images/logo.jpg') }}">
    <title> GIA TECH IT SOLUTIONS </title>
</head>

<body>
    <div id="app">
        <landing-page :data="{{ json_encode($data) }}"></landing-page>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>