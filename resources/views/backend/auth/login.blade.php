@extends('backend.layouts.applogin')
@section('title', 'Login')
@section('content')
<div class="wrapper">
    <div class="main-panel">
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section id="login" class="auth-height">
                    <div class="row full-height-vh m-0">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="card overflow-hidden">
                                <div class="card-content">
                                    <div class="card-body auth-img">
                                        <div class="row m-0">
                                            <div class="col-lg-12 col-12 px-4 py-3" style="width:400px">
                                                <form action="webadmin/login" method="POST">
                                                    @csrf
                                                    <h4 class="mb-3 text-center text-primary d-none d-lg-block d-md-block">Welcome</h4>
                                                    <h5 class="mb-2 text-center text-primary d-block d-lg-none d-md-none">Welcome</h5>
                                                    <h5 class="mb-2 text-center text-danger d-none font-weight-bold d-lg-block d-md-block">Indiana Gratings Private Limited</h5>
                                                    <h6 class="mb-2 text-center text-danger d-block d-lg-none font-weight-bold d-md-none">Indiana Gratings Private Limited</h6>
                                                    <br/>
                                                    @php
                                                        $status = session('status');
                                                    @endphp
                                                    @if($status)
                                                        <div class='badge bg-light-success mb-1 mr-2'>
                                                            {{ $status }}
                                                        </div>
                                                    @endif
                                                    <div class="mb-3">
                                                        <input type="email" class="form-control" placeholder="Email" required="" name="email">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control mb-2" placeholder="Password" required="" name="password">
                                                        <div class="d-sm-flex justify-content-between mb-3 font-small-2">
                                                            <div class="remember-me mb-2 mb-sm-0"></div>
                                                            @if(Route::has('password.request'))
                                                                <a class="underline text-sm text-gray-600 hover:text-gray-900" href={{ route('password.request') }}>
                                                                    {{ ('Forgot your password?') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-primary form-control">Login</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="text-center mb-3">
                                                    @error('msg')
                                                    <div class="text-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
@endsection
