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
                                            <div class="col-lg-12 col-12 px-4 py-3" style="width:">
                                                <form method="post" id="ForceTochangePwd" action="force_reset_password">
                                                    <h4 class="mb-3 text-center text-primary d-none d-lg-block d-md-block">You Need to Change Password</h4>
                                                    <h5 class="mb-2 text-center text-primary d-block d-lg-none d-md-none">You Need to Change Password</h5>
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                           
                                                            <label>Old Password<span class="text-danger">*</span></label>
                                                            <input class="form-control" required type="password" name="old_password">
                                                            <input class="form-control" type="hidden" name="id" value="{{$data['id']}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>New Password<span class="text-danger">*</span></label>
                                                            <input class="form-control" required type="password" name="new_password">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Confirm Password<span class="text-danger">*</span></label>
                                                            <input class="form-control" required type="password" name="confirm_password">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="pull-right">
                                                            <button type="submit" class="btn btn-success" >Reset Password</button>
                                                                <!-- <button type="submit" class="btn btn-success btn-sm">Reset Password</button> -->
                                                            </div>
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
