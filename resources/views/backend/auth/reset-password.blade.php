@extends('backend.layouts.auth-app')
@section('content')
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ url('public/assets/images/background/login-register.jpg') }});">
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal" method="post" action="{{ route('admin.auth.reset.password.post',['id'=>$verifyUser->token]) }}">
				 @csrf()
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Reset Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
							@if($errors->any())
								<div class="alert alert-danger" role="alert">
									{{ $errors->first() }}
								</div>
							@endif
                        </div>
                    </div>
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
                            <div class="controls">
                                <input class="form-control" name="email" type="text" placeholder="Email" value="{{ $verifyUser->email }}" disabled>
                            </div>
                        </div>
						<div class="form-group ">
                            <div class="controls">
                                <input class="form-control" name="password" type="Password" placeholder="Password">	
                                 @if($errors->has('password')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('password') }}</span> @endif
                            </div>
                        </div>
						<div class="form-group ">
                            <div class="controls">
                                <input class="form-control" name="password_confirmation" type="password" placeholder="Confirm Password">
                            </div>
                        </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
						    <button class="btn btn-primary btn-lg w-100 text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
					<div class="form-group m-b-0">
						<div class="col-sm-12 text-start">
							 <a href="{{ route('admin.auth.login') }}" class="btn btn-info btn-lg w-100 waves-effect waves-dark"><i class="fa fa-chevron-left m-r-10"></i>Back To Login</a>
						</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection