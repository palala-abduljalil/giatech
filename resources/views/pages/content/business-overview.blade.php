@extends('master')

@section('title', "Content Management")

@section('content')
<div id="manage-content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mt-1">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold">
                                <i class="fas fa-file-invoice mr-2"></i>
                                Content Management
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    Content Management
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="{{ route('content.business-overview') }}">
                                        Business Overview
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
                    <business-overview />
                </div>
            </div>
        </div>
    </section>
</div>
@endsection