<?php

namespace App\Interfaces;
use Symfony\Component\HttpFoundation\Request;

interface BookingInterface{

      /**
      * Get User Booking details
      * 
      * @access  public
      */
      public function Adminemail();

      public function AcceptCancelStatus($request);

      public function wallet();
      
      public function bookingSlot($request);

}
?> 