@extends('backend.layouts.applogin')
@section('title', 'Reset Password')
@section('content')
    <div class="wrapper">
        <div class="main-panel">
            <!-- BEGIN : Main Content-->
            <div class="main-content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <!--Registration Page Starts-->
                    <section id="regestration" class="auth-height">
                        <div class="row full-height-vh m-0">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="card overflow-hidden">
                                    <div class="card-content">
                                        <div class="card-body auth-img">
                                            <div class="row m-0">
                                                <div class="col-md-12 px-4 py-3">
                                                    <form method="POST" action="{{ route('password.update') }}">
                                                        @csrf
                                                        <h4 class="card-title mb-2">Reset Password</h4><br>
                                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" value="{{ $request->route('email') }}" readonly><br>
                                                        <input type="password" class="form-control mb-2" placeholder="Password" name="password"><br>
                                                        <input type="password" class="form-control mb-2" placeholder="Confirm Password" name="password_confirmation">
                                                        <br>
                                                        <div class="text-center">
                                                            <button class="btn btn-primary" type="submit">Reset</button>
                                                        </div><br>
                                                        <p>Go Back to <a href="{{url('/webadmin')}}"><u>Login page</u></a></p>
                                                        @if($errors->any())
                                                            <div class="text-center">
                                                                <span style="color:red">{{$errors->first()}}</span><br/>
                                                            </div>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--Registration Page Ends-->

                </div>
            </div>
            <!-- END : End Main Content-->
        </div>
    </div>
@endsection
   