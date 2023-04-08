@extends('backend.layouts.auth-app')
@section('content')
<section id="wrapper">
<div class="login-register overlay" style="background-image:url({{ url('public/front/assets/images/image1.jpg') }});">
        <div class="login-box card rounded">
            <div class="card-body p-lg-4">
                <div class="logo mb-3 text-center">
                   <img class="img-fluid logo-img w-50" src="{{ url('public/front/assets/images/logo.png') }}" alt="Groom Me">
                </div>
                <form method="POST" class="form-horizontal form-material" id="loginform" action="{{ route('admin.auth.login.post') }}">
                    @csrf()
                    <h3 class="text-center m-b-20">Sign In</h3>
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first() }}
                    </div>
                    @endif
					{{-- Success Alert --}}
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible mt-4">
					       {!! session('success')!!}        
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <span aria-hidden="true"></span> </button>
                        </div>
                        @endif
                        {{-- Error Alert --}}
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible mt-4">
                            {{session('error')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <span aria-hidden="true"></span> </button>
                        </div>
                        @endif
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="email" required="" placeholder="Email">
                            @if($errors->has('email')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('email') }}</span> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="password" placeholder="Password">
                            @if($errors->has('password')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('password') }}</span> @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div class="form-check">
								    <input type="checkbox" class="form-check-input" id="customCheck1" name="remember" value="1" {{isset($_COOKIE['rememberchecked']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customCheck1">Remember me</label>
                                </div>
                                <!-- <div class="ms-auto">
                                    <a href="{{ route('admin.auth.forgot.password') }}" class="text-muted"><i class="fas fa-lock m-r-5"></i> Forgot pwd?</a>
                                </div> --> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mb-0">
                        <div class="col-xs-12">
                            <button class="btn w-100 btn-lg btn-info btn-rounded text-white" type="submit">Log In</button>
                        </div>
                    </div>

                </form>
                <form class="form-horizontal" id="recoverform" action="index.html">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg w-100 text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection