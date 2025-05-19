@extends('user.layouts.layout')
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row">
            <div class="col-xl-4 col-xl-100 box-col-12 ps-4 pe-4 left-background">
                <div class="row bg-light p-3 pt-4 pb-4 align-items-start">
                    <div class="col-12 col-xl-50 box-col-6">
                        <div class="card welcome-card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="flex-grow-1 col-md-6 col-12 custom-p-1200 mb-3">
                                        <h1>Hello, {{ auth()->user()->name }}</h1>
                                        <h4>{{ $message }} </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection


@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/css/external-css/dashboard.css') }}">
@endsection

@section('js_plugins')

@endsection
