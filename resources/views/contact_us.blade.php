@extends('layouts.app')
@section('content')
<!-- Banner -->
<div id="banner" class="style2 overlay">
  <img src="{{ url('public/front/assets/images/banner/contact-us.jpg') }}" alt="Contact Us" class="img-fluid">
  <div class="description absolute-center">
	<div class="container text-center">
	  <h1 class="mb-0">Contact Us</h1>
	</div>
  </div>
</div>
<!-- Banner -->
<!-- Content -->
<div id="content">
  <!-- Contact Us -->
  <section class="section contact-us">
	<div class="container">
	  <div class="row">
		<div class="col-md-6">
		  <h3>Head Office</h3>
		  <div class="contact-area mb-3 mb-md-5">
			<address>
			  <p>
				<span class="icon2"><i class="fa fa-map-marker-alt" aria-hidden="true"></i></span>
				Groom Me Technologies Inc.<br />
				2411 Newcastle Crescent,<br />
				Oakville, ON<br />
				L6M 4P9
			  </p>
			</address>
			<p><span class="icon2"><i class="fa fa-phone fa-rotate-90" aria-hidden="true"></i></span>
			  <a href="tel:1-(855) 476-6663">1-(855) 476-6663</a>
			</p>
			<p><span class="icon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
			  <a href="mailto:contactus@groommetech.com">contactus@groommetech.com</a>
			</p>
		  </div>
		  <h4>Follow Us</h4>
		  <ul class="list-unstyled social-links style2 mb-4 mb-md-0">
			<li><a href="https://twitter.com/groommetech" target="_blank"><i class="fab fa-twitter"></i></a></li>
			<li><a href="https://www.facebook.com/groommetech" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
			<li><a target="_blank" href="https://www.instagram.com/Groomme_technologies/"><i class="fab fa-instagram"></i></a></li>
			<li><a href="https://www.tiktok.com/@groomme.inc" target="_blank"><i class="fab fa-tiktok"></i></a></li>
		  </ul>
		  <h4>Connect with</h4>
		  <figure class="figure whatsapp-scanner">
		  <img src="{{ url('public/front/assets/images/wh.png') }}" alt="Whatsapp Scanner" class="img-fluid w-50 rounded">
		  </figure>
		</div>
		<div class="col-md-6">
		  <h3>Send Query</h3>
		  <p>Kindly fill up your details and submit your query</p>
		  <form action="{{ route('contact.post') }}" class="form" method="post" id="contact-form">
		  @csrf
			<div class="form-group">
			  <label for="name">Your Name <span class="text-danger">*</span></label>
			  <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required data-parsley-error-message="The name field is required."/>
			  @if($errors->has('name')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('name') }}</span> @endif
			</div>
			<div class="form-group">
			  <label for="email">Your Email <span class="text-danger">*</span></label>
			  <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required />
			   @if($errors->has('email')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('email') }}</span> @endif
			</div>
			<div class="form-group">
			  <label for="phone">Contact Number <span class="text-danger">*</span></label>
			  <input class="form-control" type="tel" name="phone" id="phone" value="{{ old('phone') }}" required data-parsley-type="number">
			  @if($errors->has('phone')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('phone') }}</span> @endif
			</div>
			
			<div class="form-group">
			  <label for="message">Your Query</label>
			  <textarea name="message" id="message" class="form-control"></textarea>
			</div>
			<div class="form-group captcha">
			  <span>{!! captcha_img() !!}</span>
				<button type="button" class="btn btn-primary btn-sm" class="reload" id="reload">
				&#x21bb;
				</button>
			</div>
			<div class="form-group">
			  <label for="postcode">Enter Captcha</label>
			<input id="captcha" type="text" class="form-control" name="captcha" required data-parsley-error-message="The captcha field is required.">
			@if($errors->has('captcha')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('captcha') }}</span> @endif
			</div>
			<button type="submit" class="btn btn-primary btn-block">Send</button>
		  </form>
		</div>
	  </div>
	</div>
  </section>
  <!-- /Contact Us -->
  <!-- Google Map -->
  <section id="map">
	<iframe
	  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2896.391958486472!2d-79.75967838450872!3d43.45241357912882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b670ea6165889%3A0x7788bcfaf5ebd45e!2sGroom%20Me%20Technologies%20Inc.!5e0!3m2!1sen!2sin!4v1649411782224!5m2!1sen!2sin"
	  style="width:100%; height:100%; border:0" allowfullscreen="" loading="lazy"
	  referrerpolicy="no-referrer-when-downgrade"></iframe>

  </section><!-- Google Map -->
</div>
<!-- /content -->
@endsection
@section('extrascript')
    <script type="text/javascript">
	   $(document).ready(function() {
			$('#contact-form').parsley();
		});
		 $('#reload').click(function () {
			$.ajax({
				type: 'GET',
				url: "{{ route('reload-captcha') }}",
				success: function (data) {
					$(".captcha span").html(data.captcha);
				}
			});
    });
    </script>

@endsection