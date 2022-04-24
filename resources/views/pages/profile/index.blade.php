@extends('master')

@section('title', "Profile")

@section('content')
<div class="content-page">
    <div class="content-box">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="font-weight-bold">
                                    <i class="fas fa-user mr-2"></i>
                                    Account Profile
                                </h4>
                            </div>
                            {{-- <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        User 
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a href="{{ route('users.create') }}">
                                            Create User
                                        </a>
                                    </li>
                                </ol>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-md-12">
                        <user-profile />
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection