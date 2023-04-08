<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Interfaces\BookingInterface;
use Illuminate\Support\Facades\Auth;


class BookingController extends BaseController
{
    
  protected $bookingInterface;

  public function __construct(BookingInterface $bookingInterface)
  {
      $this->bookingInterface = $bookingInterface;
  }

      /**
     * get booking api
     *
     * @return \Illuminate\Http\Response 
     */

    public function Adminemail(){
        return $this->bookingInterface->Adminemail();
    }

    public function AcceptCancelStatus(Request $request){
        return $this->bookingInterface->AcceptCancelStatus($request);
    }

    public function wallet(){
        return $this->bookingInterface->wallet();
    }
   
    public function bookingSlot(Request $request){
        return $this->bookingInterface->bookingSlot($request);
    }

}
