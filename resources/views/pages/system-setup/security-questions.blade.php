@extends('master')

@section('title', "System Setup")

@section('content')
<div id="manage-content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mt-1">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold">
                                <i class="fas fa-cogs mr-2"></i>
                                System Setup
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    System Setup
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="{{ route('system-setup.security-questions') }}">
                                        Security Questions
                                    </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-10 offset-md-1">
                    <security-questions />
                </div>
            </div>
        </div>
    </section>
</div>
@endsection