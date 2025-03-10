<head>
  <meta charset="UTF-8">

  <title>Invoice - Celeb Media</title>

  <style type="text/css">
    * {
      margin: 0;
      padding: 0;
      text-indent: 0;
    }

    table,
    tbody {
      vertical-align: top;
      overflow: visible;
    }

    @font-face {
      font-family: 'Courier-New';
      font-style: normal;
      font-weight: normal;
      src: url({{ storage_path('fonts/courier-new.ttf') }});
      /* IE9 Compat Modes
      src: local("Courier-New"), local("Courier-New"), url({{ storage_path('fonts/courier-new.ttf') }}) format("truetype");
      Legacy iOS */
    }

    body {
      // width: 970px !important;
      width: 96% !important;
      margin: auto;
      font-family: 'Courier-New', Roboto, Arial !important;
      font-size: 12px;
    }
    .cls_roboto {
      font-family: Roboto, Arial !important;
    }
.class_calibri {
  font-family: "Calibri", sans-serif !important;
}


    .ui.card>.content,
    .ui.cards>.card>.content {
      -webkit-box-flex: 0;
      -ms-flex-positive: 0;
      flex-grow: 0;
    }

    .table {
      display: table;
      width: 100%;
      border-collapse: collapse;
    }

    .table-row {

      display: table-row;
    }

    .table-cell {
      display: table-cell;
    }

    /** Define the header rules **/
    #header {
      position: fixed;
      top: 1cm;
      left: 0cm;
      right: 0cm;
      height: 5cm;
      margin-left: 2cm;
      margin-right: 2cm;
    }

    /** Define the footer rules **/
    #footer {
      position: fixed;
      bottom: 2.40cm;
      left: 0cm;
      right: 0cm;
      height: 2cm;
    }
  </style>
</head>

<body translate="no">
 <!-- Company logo part in pdf-->
  <div id="header" style="width:90%">
    <table style="width:100%">
      <tr>
        <td style="text-align: right; width:100%;">
          <h1><img src="https://www.celebdigital.in/images/logo.png" style="width: 350px;"></h1>
        </td>
      </tr>
    </table>
  </div>

  <main style="padding-top:150px;">
    <table style="width:100%">
      <tr>
        <td style="width: 100%; ">
          <table style="width: 100%; padding: 10px;">
           <!-- Headline of the pdf-->
            <tr>
              <td colspan="2"
                style="background-color: #000; color: #FFF; border: 0px solid #000; line-height:25px; padding-bottom: 5px; font-weight: bold; border-radius: 5px 5px 5px 5px; width: 100%; text-align: center; font-size:18px;">
                TAX INVOICE</td>
            </tr>
             <!-- Client details part in the pdf-->
            <tr>
              <td
                style="border: 1px solid #000;text-align: left; width: 60%; border-radius: 5px 5px 5px 5px; float: left;">
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                      <table style="width: 100%;">
                      <!-- Client name section-->
                        @foreach ($company_data as $company_data_value)
                        <tr>
                          <td style="width: 24%; font-weight: bold;">Client Name</td>
                          <td style="width: 76%; text-transform: uppercase;">: <strong>{{ $company_data_value->company_name }} </strong> </td>
                        </tr>
                        <!-- Address section-->
                        <tr>
                          <td style=" font-weight: bold;">Address (Line 1)</td>
                          <td style=" text-transform: uppercase;">: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- Address 2 section -->
                        <tr>
                          <td style=" font-weight: bold;">Address (Line 2)</td>
                          <td style=" text-transform: uppercase;">: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address_2 }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- Address 3 section -->
                        <tr>
                          <td style=" font-weight: bold;">Address (Line 3)</td>
                          <td style=" text-transform: uppercase;">: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address_3 }}
                            @endforeach
                          </td>
                        </tr>
                               <!-- Address 3 section -->
                               <tr>
                          <td style=" font-weight: bold;">Address (Line 4)</td>
                          <td style=" text-transform: uppercase;">: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address_4 }}
                            @endforeach
                          </td>
                        </tr>
                         <!-- City / District section -->
                        <tr>
                          <td style=" font-weight: bold;">City / District</td>
                          <td style=" text-transform: uppercase;">: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_location }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- State section -->
                        <tr>
                          <td style=" font-weight: bold;">State</td>
                          <td style=" text-transform: uppercase;">: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_state }}
                            @endforeach
                          </td>
                        </tr>
                         <!-- Pincode section -->
                        <tr>
                          <td style=" font-weight: bold;">Pincode</td>
                          <td style=" text-transform: uppercase;">: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_pincode }}
                            @endforeach
                          </td>
                        </tr>
                         <!-- GST No section -->
                        <tr>
                          <td style=" font-weight: bold;">GST No</td>
                          <td style=" font-weight: normal; text-transform: uppercase;">: {{ $company_data_value->gst_no }} </td>
                        </tr>
                        @endforeach
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td
                style="width: 38%; margin-left: 2%; float: left; margin-top: 10px; border: 1px solid #000;  border-radius: 5px 5px 5px 5px;">
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                    <!-- Invoice summary details part in pdf -->
                      <table style="width: 100%;">
                        <tr>
                          <td colspan="3" style="text-decoration: underline; font-size: 14px;"><b>INVOICE SUMMARY</b></td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold; width: 26%; padding-top:5px;">Date</td>
                          <td style=" font-weight: bold; width: 2%; padding-top:5px;">: </td>
                          <td style=" text-transform: uppercase; width: 72%; padding-top:5px;">{{date("d-m-Y")}}</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;">Description</td>
                          <td style=" font-weight: bold; width: 2%">: </td>
                          <td style=" text-transform: uppercase;margin-left: -20px;">@foreach ($invoice_data as
                            $invoice_data_value)
                            {{ $invoice_data_value->activity_details }}
                            @endforeach</td>
                        </tr>
                        @foreach ($invoice_data as $invoice_data_value)
                        <tr>
                          <td style=" font-weight: bold;">Invoice No</td>
                          <td style=" font-weight: bold; width: 2%">: </td>
                          <td style=" text-transform: uppercase;">{{ $invoice_data_value->invoice_sr_no }}</td>
                        </tr>

			@if($invoice_data_value->quotation_type != 'A')
	                <tr>
                          <td style=" font-weight: bold;">Quotation No</td>
                          <td style=" font-weight: bold; width: 2%">: </td>
                          <td style=" text-transform: uppercase;">{{ $invoice_data_value->quotation_sr_no }}</td>
                        </tr>
			@endif

                        @endforeach
                        <tr>
                          <td style=" font-weight: bold;">Amount Due</td>
                          <td style=" font-weight: bold; width: 2%">: </td>
                          <td style=" text-transform: uppercase;">@foreach ($invoice_data as $invoice_data_value) {{
                            $invoice_data_value->total_amount_format }} @endforeach</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
              <!-- Activity details part in pdf -->
	    <tr>
              <td colspan="2" style="width: 100%; height: 5px;"></td>
            </tr>
            <tr style="line-height: 20px !important; ">
              <td colspan="2" style="border: 1px solid #000; margin-top: 10px; padding-bottom: 5px; border-radius: 5px 5px 5px 5px; background-color: #FFF;width: 98%; padding-left: 2%;">
                <b>Activity Details</b> : @foreach ($invoice_data as $invoice_data_value)
		<span style=" text-transform: uppercase;">{{ $invoice_data_value->activity_details }}</span>
                @endforeach
              </td>
            </tr>

            <tr>
              <td colspan="2" style="width: 100%; height: 3px;"></td>
            </tr>
            <tr>
              <td colspan="2" style="width: 100%; margin-top: 10px; ">
              <!-- Selected product details column name list part in pdf -->
                <table style="width: 100%;">
                  <thead>
                    <tr style="line-height: 20px !important; height: auto;">
                      <th
                        style="border-top-left-radius: 5px; border-bottom-left-radius: 5px; font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:5%;">
                        Sno
                      </th>
                      <th
                        style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:35%">
                        Particulars</th>
                      <th
                        style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:10%">
                        Quantity</th>
                      <th
                        style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:10%">
                        Rate
                      </th>
                      <th
                        style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:12%;">
                        Amount</th>
                      <th
                        style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:12%">
                        IGST
                      </th>
                      <th
                        style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:16%; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                        Total Amount (<img src="../public/css/white-rupee-indian.png" style="width: 8px !important; height: 8px !important; margin-top: 10px !important; border: 0px; vertical-align: middle;">)</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    @php
                    $serialNumber = 1;
                    @endphp
                    @foreach ($product_data as $product_data_value)
                    <!-- Selected Product details list part in pdf -->
                    <tr style="line-height: 20px !important; height: auto;">
                      <td
                        style="border-right: 1px solid #FFF; border-top-left-radius: 5px; padding-bottom: 5px; border-bottom-left-radius: 5px; border: 1px solid #000; text-align: center;">
                        {{ $serialNumber }}</td>
                      <td style="border: 1px solid #000; padding-left: 5px; padding-bottom: 5px; ">
                        {{ $product_data_value->product_master_name }}
                      </td>
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->prd_qty_format }}</span>
                      </td>
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->product_rate_format }}</span>
                      </td>
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->product_rate_multiply_format }}</span>
                      </td>
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->prd_gst_amount_format }}</span>
                      </td>
                      <td
                        style="border: 1px solid #000; text-align: center; border-top-right-radius: 5px; border-bottom-right-radius: 5px; padding-bottom: 5px;">
                        <span>{{ $product_data_value->prd_total_amount_format }}</span>
                      </td>
                    </tr>
                    @php
                    $serialNumber++;
                    @endphp
                    @endforeach
                    <!-- Grand total of products part in pdf -->
                  </tbody>
                  <tfoot>
                    <tr style="line-height: 20px !important; height: auto;">
                      <th colspan="4"></th>
                      <th colspan="2"
                        style="font-weight: bold; background-color: #000; color: #FFF; text-align:center; border-right: 1px solid #FFF; border-top-left-radius: 5px; border-bottom-left-radius: 5px; padding-bottom: 5px;">
                        Grand Total in (<img src="../public/css/white-rupee-indian.png" style="width: 8px !important; height: 8px !important; margin-top: 10px !important; border: 0px; vertical-align: middle;">) (Round Off)
                      </th>
                      <th
                        style="font-weight: bold; background-color: #000; color: #FFF; text-align:center; border-top-right-radius: 5px; border-bottom-right-radius: 5px; padding-bottom: 5px;">
                        <b>@foreach ($invoice_data as
                          $invoice_data_value) {{ $invoice_data_value->total_amount_format }}
                          @endforeach</b>
                      </th>
                    </tr>
                    <!-- Grand total amount in words part in pdf -->
                    <tr>
                      <th colspan="7"
                        style="font-weight: bold; line-height:20px; padding-bottom: 5px; padding-right: 5px; background-color: #FFF; text-align:left; text-transform:capitalize; border: 1px solid #000; border-radius: 5px; width: 98%; padding-left: 10px;">
                        Grand Total in words : <span style='font-weight: normal'>{{ $ttlamt }} </span></th>
                    </tr>
                  </tfoot>
                </table>

              </td>
            </tr>

		<!-- <tr>
                  <td colspan="2" style="width: 100%; height: 5px;"></td>
                </tr>
                <tr style="line-height: 20px !important; ">
                  <td colspan="2" style="border: 1px solid #000; margin-top: 10px; padding-bottom: 5px; border-radius: 5px 5px 5px 5px; background-color: #FFF;width: 98%; padding-left: 2%;">
                    <table style="width: 98%"><tr><td><b>Remarks</b> : </td></tr>
			@foreach ($invoice_data as $invoice_data_value)
                        <tr><td style="border-bottom: 1px dotted #000; width: 100%;">1. <span style="text-transform: uppercase;">{{ $invoice_data_value->quotation_remarks }}</span></td></tr>
                        <tr><td style="border-bottom: 1px dotted #000;">2. <span style="text-transform: uppercase;">{{ $invoice_data_value->quotation_remarks_2 }}</span></td></tr>
                        @endforeach
                    </table>
                  </td>
                </tr> -->

		<tr>
                  <td colspan="2" style="width: 100%; height: 5px;"></td>
                </tr>
                <tr style="line-height: 20px !important; ">
                  <td colspan="2" style="border: 1px solid #000; margin-top: 10px; padding-bottom: 5px; border-radius: 5px 5px 5px 5px; background-color: #FFF;width: 98%; padding-left: 2%;">
                    <table style="width: 98%"><tr><td colspan="2"><b>Remarks</b> : </td></tr>
                        @foreach ($invoice_data as $invoice_data_value)
                        <tr><td style="border-bottom: 0px dotted #000; width: 2%;">1. </td><td style="width: 98%; border-bottom: 1px dotted #000;">{{ $invoice_data_value->quotation_remarks }}</td></tr>
                        <tr><td style="border-bottom: 0px dotted #000; width: 2%;">2. </td><td style="width: 98%; border-bottom: 1px dotted #000;">{{ $invoice_data_value->quotation_remarks_2 }}</td></tr>
                        @endforeach
                    </table>
                  </td>
                </tr>

            <tr>
              <td colspan="2" style="width: 100%; height: 5px;"></td>
            </tr>
            <tr>
              <td
                style="border: 1px solid #000;text-align: left; width: 50%; border-radius: 5px 5px 5px 5px; float: left;">
                <!-- Company details part in pdf -->
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                      <table style="width: 100%;">
                        <tr>
                          <td colspan="2" style="text-decoration: underline; font-weight: bold;"> Company Details </td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold; width:24%">Company Type</td>
                          <td style=" text-transform: uppercase; width:76%">: MSME</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;">HSN/ SAC Code</td>
                          <td style=" text-transform: uppercase;">: 998599</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;">GST No</td>
                          <td  style=" font-weight: normal; text-transform: uppercase;">: 36BMUPM8631E3ZJ</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;">PAN No</td>
                          <td style=" text-transform: uppercase;">: BMUPM8631E</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td
                style="width: 48%; margin-left: 2%; float: left; margin-top: 10px; border: 1px solid #000;  border-radius: 5px 5px 5px 5px;">
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                      <table style="width: 100%;">
                        <tr>
                          <td colspan="2" style="text-decoration: underline; font-weight: bold;"> Bank Details </td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold; width:28%">Name</td>
                          <td style=" text-transform: uppercase; width:72%">: CELEB MEDIA</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;">Bank Name</td>
                          <td style=" text-transform: uppercase;">: HDFC</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;">Account No</td>
                          <td style=" text-transform: uppercase;">: 50200029001723</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;">IFSC Code</td>
                          <td style=" text-transform: uppercase;">: HDFC1234101</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
             <!-- NOTE section in pdf -->
            <tr>
              <td colspan="2" style="width: 99%; padding-left: 1%; padding-bottom: 1px;">
                Note: All payments shall be made in favour of "<b>CELEB MEDIA</b>"
              </td>
            </tr>
            <!-- Signature section in pdf -->
            <tr>
              <td colspan="2" style="width: 100%; margin-top: 10px; padding-top: 10px;">
                <table style="text-align: right; width: 100%;">
                  <tr>
                    <td style="padding-right: 75px;"><span
                        style=" border-bottom: 1px solid #000;">For Celeb
                        Media</span></td>
                  </tr>
                  <tr>
                    <td><img src="../storage/app/sign.png"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </main>
<!-- Footer Details part in pdf -->
<div id="footer">
    <table style="width:100%; border-collapse: collapse;">
      <tr>
        <td colspan="3" style="clear: both; text-align: left; padding-left:2%; padding-bottom: 30px; border-bottom: 0px solid #000;">E & O.E.</td>
      </tr>
      <!-- Company Address Details part in Footer of pdf -->
      <tr>
        <td style="width:22%; padding-left:2%; text-align: center; float: left;">
          <img src="../storage/app/cm_logo.png" style="width: 150px; margin-top: 30px;">
        </td>
        <td
          style="width: 56%;float: left;padding-left: 10px; padding-bottom: 10px; border-right: 1px solid #f23c00;border-left: 1px solid #f23c00; line-height: 20px; margin-top: -15px;" class="class_calibri">
          <img src="../public/css/location_icon.png"
            style="width: 16px; height: auto; vertical-align: middle; margin-top: 15px;">
          3rd Floor, 91 Springboard, Mythri Square, Gachibowli - Miyapur Road, <br>Landmark: Opposite AMB Mall,
          Kondapur, Hyderabad, Telangana- 500084, India.<br>
          <img src="../public/css/gst_icon.png"
            style="width: 16px; height: auto; border: 0px;vertical-align: middle; margin-top: 15px;">
	<span class="class_calibri" style='font-weight: bold;'>GST No : 36BMUPM8631E3ZJ</span>
        </td>
        <td style="width:22%; padding-left: 10px; padding-bottom: 10px; float: left;line-height: 20px; margin-top: -10px;" class="class_calibri">
          <img src="../public/css/phone_icon.png"
            style="width: 16px; height: auto; padding-right: 10px; border: 0px;vertical-align: middle; margin-top: 10px;">
          +91 7036-365-247
          <br>
          <img src="../public/css/email_icon.png"
            style="width: 16px; height: auto; padding-right: 10px; border: 0px; vertical-align: middle; margin-top: 10px;">
          info@celebdigital.in
          <br>
          <img src="../public/css/internet_icon.png"
            style="width: 16px; height: auto; padding-right: 10px; border: 0px; vertical-align: middle; margin-top: 10px; image-rendering: pixelated !important; transform: translateZ(0) !important;">
          www.celebdigital.in
        </td>
      </tr>

      <tr>
        <td colspan="3" style="width:100%; float: left; border-top: 1px solid #f23c00;">
          <img src="../storage/app/footer.png" style="width: 100%;">
        </td>
      </tr>
    </table>
  </div>

</body>

</html>


