@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <user-reniew :data="{{ $data }}"/>
        </div>
    </div>
</div>
@endsection
