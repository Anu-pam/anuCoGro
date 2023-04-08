@extends('layouts.app')
@section('content')
    <!-- Banner -->
    <div id="banner" class="style2 overlay">
      <img src="{{ url('public/front/assets/images/banner/about-us.jpg') }}" alt="About Us" class="img-fluid">
      <div class="description absolute-center">
        <div class="container text-center">
          <h1 class="mb-0">About Us</h1>
        </div>
      </div>
    </div>
    <!-- Banner -->
    <!-- Content -->
    <div id="content">
      <!-- Our Story -->
      <section class="section our-story">
        <div class="container custom-container">
          <div class="row align-items-md-center">
            <div class="col-md-6 px-5 px-sm-5 mb-5 mb-md-0">
              <figure class="figure figure-style mb-0">
                <img class="img-fluid w-100" src="{{ url('public/front/assets/images/about-us.jpg') }}" alt="About Us">
              </figure>
            </div>
            <div class="col-md-6 pl-xl-5">
              <h2>Our Story</h2>
              <p><span class="text-primary">Groom Me</span> brings added value to people's lives through
                seamless online salon, spa/barber service
                bookings.</p>

              <p>We have done the research and the consensus is that this app will lessen
                service wait times and will provide you the convenience of booking live service appointments on the
                spot. </p>

              <p>Over the last few years we have noticed a great decrease in salon/spa and barbershop visits,
                leaving shop owners and their employees looking for other alternatives. Now, with the Groom Me app, shop
                owners and
                workers can instantly go live on our app when their shop is not busy. Open the app and connect with
                customers in your area. </p>

              <p>It also gives the freedom for all service professionals to work on their own time as exclusive
                independent contractors.
                When you’re free for clients click ‘Live Mobile’ or ‘Live Stationary’ and unclick the tabs to let
                customers
                know you are unavailable.</p>

              <p>Likewise, the Groom Me app gives our customers the freedom and convenience of booking live service
                professionals at your disposal.
                Spur of the moment appointments can be made which will eliminate the hassle of booking appointments
                around the service providers
                availability. For those that prefer scheduled bookings, this option is still available through the app.
              </p>

              <p>We believe that most people prefer in-house services but have no outlet to provide these services.
                Now the wait is over, we at Groom Me are dedicated to providing the most unique and hassle-free service
                for our
                customers and partners alike.
              </p>
            </div>
          </div>
        </div>
      </section>
      <!-- /Our Story -->
    </div>
    <!-- /content -->
@endsection