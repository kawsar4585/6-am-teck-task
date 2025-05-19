@extends('auth.layouts.layout')
@section('content')
    <div class="account-content">

        <div class="container">

            <!-- Account Logo -->
            <div class="account-logo">
                <a href="javascript:void(0)"><img src="https://6amtech.com/wp-content/uploads/2023/06/6amTech-Primary-Logo.svg" alt="{{ config('app.name') }}"></a>
            </div>
            <!-- /Account Logo -->

            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Login</h3>
                    <p class="account-subtitle">Access to your dashboard</p>

                    <!-- Account Form -->
                    <form action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="input-block mb-4">
                            <label class="col-form-label">Email</label>
                            <input class="form-control" type="text" name="email" value="{{ old('email') }}" required>
                            <span class="email_error ie-span"></span>
                        </div>
                        <div class="input-block mb-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="col-form-label">Password</label>
                                </div>
                            </div>
                            <div class="position-relative">
                                <input class="form-control" type="password" name="password" value="" id="password" required>
                                <span class="fa-solid fa-eye-slash toggle-password" id="toggle-password"></span>
                            </div>
                            <span class="password_error ie-span"></span>
                        </div>
                        <div class="input-block mb-4 d-flex align-items-center">
                            <label for="remember_me"> <input type="checkbox" name="remember_me" id="remember_me" class="me-1" value="1"> <span>Remember me?</span></label>
                        </div>
                        <div class="input-block mb-4 text-center">
                            <button class="btn btn-primary account-btn" type="submit">Login</button>
                        </div>
                        <div class="input-block mb-4 text-end">
                            Don't have an account? <a href="{{ route('register') }}">Register here</a>
                        </div>
                    </form>
                    <!-- /Account Form -->

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_plugins')

@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $("#loginForm").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');
                formPost(url,formData,'redirect', function (xhr) {
                    if(xhr.status == 422){
                        $.each(xhr.responseJSON.errors, function(key, value){
                            $("."+key+"_error").text(value).show();
                            toastr.error(value);
                        });
                    }else{
                        toastr.error(xhr.message);
                    }
                });
            });
        });
    </script>
@endsection
