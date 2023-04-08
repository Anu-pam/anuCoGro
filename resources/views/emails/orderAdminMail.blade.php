@include('emails.includes.header')
@php 
    $taxAndPrice = App\Http\Helpers\Common::TaxWithAmount($data['order']->detail->sum('price'));
@endphp

<table width="640"
        style="max-width: 640px;min-width: 320px;width: 100% !important;border-collapse: collapse;border-spacing: 0;border: 0px;"
        class="wrapper" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <!-- header -->
                <table class="header" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td class="banner" background="https://groommetech.com/public/uploads/email/banner5.jpg" bgcolor="#876059" width="100%"
                            style="height: 182px;background-repeat: no-repeat;background-size: cover;background-position: right center;"
                            valign="top">
                            <!--[if gte mso 9]>
                            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;height:182px;">
                                <v:fill type="tile" src="banner.png" color="#876059" />
                                <v:textbox inset="0,0,0,0">
                            <![endif]-->
                            <div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="15"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-2" style="margin: 0;padding: 0 39px;">
                                            <a href="https://www.google.com/"
                                                style="cursor: pointer !important;text-decoration: none !important;"><img
                                                    style="width:112px" src="{{ App\Http\Helpers\Common::showImages('front/assets/images/logo.png') }}" alt="groom-me"
                                                    style="vertical-align: middle;"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="15"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td class="px-2" align="center">
                                                        <!-- <div class="h1">Your services order is confirmed.
                                                        </div> -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="20">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!--[if gte mso 9]>
                                </v:textbox>
                            </v:rect>
                            <![endif]-->
                        </td>


                    </tr>
                </table>
                <!-- /header -->
                <!-- content -->
                <table class="content" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td height="35">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="px-2" style="margin: 0;padding: 0 39px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <div class="h1"><strong>Your services order is confirmed.</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="25">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text1">
                                            <span class="h3"><strong></strong></span>,<br>
                                            We’re happy to let you know that we’ve
                                            received your order.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="15">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                       
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td>
                                                    <div class="h4"><strong>Order</strong> :
                                                        <span class="h3 text-success">#{{ $data['order']->order_id}}</span>
                                                    </div>
                                                </td>
                                                <td align="right">
                                                    <div class="text1"><strong>Booked On</strong> :
                                                    {{ (!empty($data['order']->order_date))?App\Http\Helpers\Common::dateFormatChange($data['order']->order_date):'-' }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td>
                                                    <div class="h4"><strong>Booking Slot</strong> :</div>
                                                </td>
                                                <td align="right">
                                                    <div class="text1">{{ (!empty($data['order']->order_date))?App\Http\Helpers\Common::timeFormat($data['order']->created_at):'-' }}  to 12:00 pm - {{ (!empty($data['order']->order_date))?App\Http\Helpers\Common::dayWithDateFormat($data['order']->created_at):'-' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20" style="border-bottom: 1px solid #ced4da">
                                        &nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="25">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td>
                                                    <table width="100%" cellpadding="0" cellspacing="0"
                                                        border="0">
                                                        <tr>
                                                            <td>
                                                                <div class="h4 pb-20"><strong>Customer
                                                                        Info</strong>
                                                                </div>
                                                                <div class="text2"><strong>{{ $data['order']->costomerName->name}}
                                                                        </strong>
                                                                </div>
                                                                <div class="text2">
                                                                    <address>{{ !empty($data['order']->address) ? $data['order']->address : '' }}</br>
                                                                     {{ !empty($data['order']->phone_no) ? $data['order']->phone_no : '' }}
                                                                    </address> 
                                                                </div>
                                                            </td>
                                                </td>
                                                <td align="right">
                                                    <div class="h4 pb-20"><strong>Professional Info</strong>
                                                    </div>
                                                    <div class="text2"><strong>{{ !empty($data['order']->ProfessionalUser->name) ? $data['order']->ProfessionalUser->name : '' }}</strong></div>
                                                    <div class="text2">
                                                    <address>{{ !empty($data['order']->professioinlalAddress->location) ? $data['order']->professioinlalAddress->location : '' }}</br>
                                                             {{ !empty($data['order']->professioinlalAddress->phone_no) ? $data['order']->professioinlalAddress->phone_no : '' }}
                                                    </address>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="h2"><strong>Here what you have ordered</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="h4"><strong>Services Booked:</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20" style="border-bottom: 1px solid #ced4da">
                                        &nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="15">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tbody>
                                            @foreach($data['order']->detail as $index=>$detail)
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td width="15">&nbsp;</td>
                                                                <td>
                                                                    <img class="img-fluid"
                                                                    src="{{ App\Http\Helpers\Common::getServiceImageUrl($detail->orderserviceImages) }}" width="50" alt="Img">
                                                                </td>
                                                                <td width="15">&nbsp;</td>
                                                                <td>
                                                                    <div class="text1"><strong>{{ !empty($detail->services->name) ? $detail->services->name : '' }}</strong></div>
                                                                    <div class="text3">{{ !empty($detail->services->Service_cat->name) ? $detail->services->Service_cat->name : '' }}</div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td align="right">{{ App\Http\Helpers\Common::showTotalAmount($detail->price) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td height="20" style="border-bottom: 1px solid #ced4da"
                                                        colspan="2">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="15" colspan="2">&nbsp;</td>
                                                </tr>
                                             <tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td>
                                                <table width="100%" cellpadding="0" cellspacing="0"
                                                        border="0">
                                                        @foreach($taxAndPrice['tax'] as $taxs)
                                                        <tr>
                                                            <td>
                                                                <div class="text1">{{$taxs['type']}} ({{ $taxs['tax']}}) :</div>
                                                            </td>
                                                            <td align="right">
                                                                <div class="text1"> {{  $taxs['price'] }}</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="10" colspan="2">&nbsp;</td>
                                                        </tr>
                                                        @endforeach
                                                   
                                                        <tr>
                                                            <td>
                                                                <div class="text1">Sub Total</div>
                                                            </td>
                                                            <td align="right">
                                                                <div class="text1">{{ $taxAndPrice['subtotal'] }}</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="10" colspan="2">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="text1">Total</div>
                                                            </td>
                                                            <td align="right">
                                                                <div class="text1 text-success">
                                                                    <strong>{{ $taxAndPrice['total'] }}</strong>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="35" colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="h4"><strong>Payment Details:</strong></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="15" colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <img class="img-fluid" src="{{ App\Http\Helpers\Common::showImages('uploads/email/mastercard.png') }}"
                                                                    width="30" alt="Mastercard">
                                                            </td>
                                                            <td width="15">&nbsp;</td> 
                                                            <td>
                                                                <div class="text2">
                                                                    <strong>Mastercard</strong>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="text3">&nbsp;(............6500)
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align="right">{{ $taxAndPrice['total'] }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="35" colspan="2">&nbsp;</td>
                    </tr>
                    <!-- button -->
                    <tr>
                        <td align="center">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <!--[if mso]>
                                                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://www.google.com/" style="height:40px;v-text-anchor:middle;width:150px;" arcsize="0%" strokecolor="#cf453d" fill="t">
                                                            <v:fill type="tile" src="" color="#cf453d" />
                                                            <w:anchorlock/>
                                                            <center style="color:#ffffff;font-family:sans-serif;font-size:13px;font-weight:bold;">View order</center>
                                                        </v:roundrect>
                                                        <![endif]--><a href="#" style="background-color:#cf453d;background-image:url();border:1px solid #cf453d;border-radius:0px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;mso-hide:all;">View
                                                            order</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- /button -->
                    <tr>
                        <td height="15" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td height="20" style="border-bottom: 1px solid #ced4da" colspan="2">
                            &nbsp;</td>
                    </tr>
                    <tr>
                        <td height="15" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="text1">
                                If you have any questions, contact us here or call us on
                                <strong>1-(855) 476-6663!</strong>
                            </div>
                            <div class="text1">
                                We are here to help!
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="20">&nbsp;</td>
        </tr>
    </table>
    <!-- /content -->
    <!-- footer   -->
    @include('emails.includes.footer')
    <!-- footer -->
  <!-- /sociable -->
						</td>
					</tr>
				</table>
				
				</td>
		</tr>
    </table>
   
</body>

</html>