@extends('master')

@section('title', "Home")

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome!
                    {{ auth()->user()->employee->firstName }}
                    {{ strtoupper(auth()->user()->employee->middleName[0]). '. ' }}
                    {{ auth()->user()->employee->lastName }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    setTimeout(function(){ 
        const element = document.getElementById("main-body");
        element.classList.add("bodyLoaded");    
    }, 2000);
</script>
@endsection