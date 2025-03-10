<head>
  <meta charset="UTF-8">
  <!-- Title  -->
  <title>Quotation - Celeb Media</title> 
  <style type="text/css">
    * {
      margin: 0;
      padding: 0;
      text-indent: 0;
      letter-spacing: 0px !important;
      font-family: 'Courier New' !important;
    }

    table,
    tbody {
      vertical-align: top;
      overflow: visible;
	letter-spacing: -1px !important;
    }
    .fwbold { font-family: "Courier New Bold" !important; font-weight: bold !important; }

    body {
      // width: 970px !important;
      width: 96% !important;
      margin: auto;
      font-family: 'Courier New' !important;
      font-size: 11px !important;
	letter-spacing: 0px !important;
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
      bottom: 2.1cm;
      left: 0cm;
      right: 0cm;
      height: 2cm;
    }
  </style>
</head>

<body translate="no">

  <div id="header" style="width:90%;">
    <table style="width:100%">
      <tr>
        <td style="text-align: right; width:100%;">
          <h1><img src="https://www.celebdigital.in/images/logo.png" style="width: 350px;"></h1>
        </td>
      </tr>
    </table>
  </div>

  <main style="padding-top:150px;">
    <table style="width:100%;">
      <tr>
        <td style="width: 100%; ">
        <!-- Heading of this page -->
          <table style="width: 100%; padding: 10px;">
            <tr>
              <td class="cls_sans" colspan="2" style="background-color: #000; color: #FFF; border: 0px solid #000; line-height:25px; padding-bottom: 5px; border-radius: 5px 5px 5px 5px; width: 100%; text-align: center; font-size:18px;" class="fwbold">
                QUOTATION</td>
            </tr>

            <tr>
              <td style="border: 1px solid #000;text-align: left; width: 70%; border-radius: 5px 5px 5px 5px; float: left;">
              <!-- Client name detalis for Quotation pdf -->
                <table style="width: 100%; font-family: 'Courier New', Arial !important;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                      <table style="width: 100%; font-family: 'Courier New', Arial !important;">
                        @foreach ($company_data as $company_data_value)
                        <tr>
                          <td style="width: 27%;" class="fwbold">Client Name</td>
                          <td style="width: 73%;" class="fwbold"> : {{ $company_data_value->company_name }}</td>
                        </tr>
                        <!-- Address details for Quotation pdf -->
                        <tr>
                          <td class="fwbold">Address (Line 1)</td>
                          <td>: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- Address details for Quotation pdf -->
                        <tr>
                          <td class="fwbold">Address (Line 2)</td>
                          <td>: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address_2 }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- Address details for Quotation pdf -->
                        <tr>
                          <td class="fwbold">Address (Line 3)</td>
                          <td>: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address_3 }}
                            @endforeach
                          </td>
                        </tr>
                         <!-- Address details for Quotation pdf -->
                         <tr>
                          <td class="fwbold">Address (Line 4)</td>
                          <td>: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_address_4 }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- City / District for Quotation pdf -->
                        <tr>
                          <td class="fwbold">City / District</td>
                          <td>: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_location }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- State for Quotation pdf -->
                        <tr>
                          <td class="fwbold">State</td>
                          <td>: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_state }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- Pincode for Quotation pdf -->
                        <tr>
                          <td class="fwbold">Pincode</td>
                          <td>: @foreach ($invoice_data as $invoice_data_value)
                            {{ $invoice_data_value->company_pincode }}
                            @endforeach
                          </td>
                        </tr>
                        <!-- GST No for Quotation pdf -->
                        <tr>
                          <td class="fwbold">GST No</td>
                          <td class="">: {{ $company_data_value->gst_no }} </td>
                        </tr>
                        @endforeach
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td style="width: 28%; margin-left: 2%; float: left; margin-top: 10px; border: 1px solid #000; border-radius: 5px 5px 5px 5px;">
              <!-- QUOTATION SUMMARY details for Quotation pdf -->
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                      <table style="width: 100%;">
                        <tr>
                          <td colspan="3" style="text-decoration: underline; font-size: 14px;"><b>QUOTATION SUMMARY</b></td>
                        </tr>
                        <!-- QUOTATION SUMMARY date -->
                        <tr>
                          <td style="width: 31%; padding-top:5px;" class="fwbold">Date</td>
                          <td style="width: 2%; padding-top:5px;" class="fwbold">: </td>
                          <td style=" text-transform: uppercase; width: 67%; padding-top:5px;">{{date("d-m-Y")}}</td>
                        </tr>
                        <!-- QUOTATION SUMMARY Description -->
                        <tr>
                          <td style="" class="fwbold">Description</td>
                          <td style="width: 2%" class="fwbold">: </td>
                          <td style=" text-transform: uppercase;margin-left: -20px;">@foreach ($invoice_data as
                            $invoice_data_value)
                            {{ $invoice_data_value->activity_details }}
                            @endforeach
                          </td>
                        </tr>
                        @foreach ($invoice_data as $invoice_data_value)
                        <!-- QUOTATION SUMMARY Quotation No -->
                        <tr>
                          <td class="fwbold">Quotation No</td>
                          <td style="width: 2%" class="fwbold">: </td>
                          <td style=" text-transform: uppercase;">{{ $invoice_data_value->quotation_sr_no }}</td>
                        </tr>
                         <!-- QUOTATION SUMMARY Material Code -->
                        <tr>
                          <td class="fwbold">Material Code</td>
                          <td style=" width: 2%" class="fwbold">: </td>
                          <td style=" text-transform: uppercase;">{{ $invoice_data_value->material_code ?? 'NOT
                            AVAILABLE' }}</td>
                        </tr>
                        @endforeach
                        <!-- QUOTATION SUMMARY Amount Due -->
                        <tr>
                          <td class="fwbold">Amount Due</td>
                          <td style="width: 2%" class="fwbold">: </td>
                          <td style=" text-transform: uppercase;">@foreach ($invoice_data as $invoice_data_value) {{
                            $invoice_data_value->total_amount_format }} @endforeach</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
              <!-- Activity Details for quotation pdf -->
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
              <td colspan="2" style="width: 100%; height: 5px;"></td>
            </tr>
            <tr>
              <td colspan="2" style="width: 100%; margin-top: 10px; ">
                <table style="width: 100%;">
                  <thead>
                    <tr style="line-height: 20px !important; height: auto;">
                    <!-- Column Names -->
                    <!-- serialNumber in pdf -->
                      <th style="border-top-left-radius: 5px; border-bottom-left-radius: 5px; padding-bottom: 5px; background-color: #000; color: #FFF; width:5%;" class="fwbold">
                        Sno
                      </th>
                      <!-- Particulars in pdf -->
                      <th style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:35%" class="fwbold">
                        Particulars</th>
                        <!-- Quantity in pdf -->
                      <th style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:10%" class="fwbold">
                        Quantity</th>
                        <!-- Rate in pdf -->
                      <th style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:10%" class="fwbold">
                        Rate
                      </th>
                      <!-- Amount in pdf -->
                      <th style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:12%;" class="fwbold">
                        Amount</th>
                         <!--  GST @ 18% in pdf -->
                      <th style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:12%" class="fwbold">
                        GST @ 18%
                      </th>
                      <!--  Total Amount in pdf -->
                      <th style="font-weight: bold; padding-bottom: 5px; background-color: #000; color: #FFF; width:16%; border-top-right-radius: 5px; border-bottom-right-radius: 5px;" class="fwbold">
                        Total Amount</th>
                    </tr>
                  </thead>

                  <tbody>

                    @php
                    $serialNumber = 1;
                    @endphp
                    @foreach ($product_data as $product_data_value)
                    <!-- Column Values -->
                    <tr style="line-height: 20px !important; height: auto;">
                    <!-- Sno -->
                      <td style="border-right: 1px solid #FFF; border-top-left-radius: 5px; padding-bottom: 5px; border-bottom-left-radius: 5px; border: 1px solid #000; text-align: center;">
                        {{ $serialNumber }}
                      </td>
                      <!-- Product Name -->
                      <td style="border: 1px solid #000; padding-left: 5px; padding-bottom: 5px; ">
                        {{ $product_data_value->product_master_name }}
                      </td>
                         <!-- Product Quantity -->
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->prd_qty_format }}</span>
                      </td>
                      <!-- Product Rate -->
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->product_rate_format }}</span>
                      </td>
                      <!-- Product Subtotal Amount -->
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->product_rate_multiply_format }}</span>
                      </td>
                       <!-- Product Gst Amount -->
                      <td style="border: 1px solid #000; text-align: center; padding-bottom: 5px;">
                        <span>{{ $product_data_value->prd_gst_amount_format }}</span>
                      </td>
                      <!-- Product Total Amount -->
                      <td style="border: 1px solid #000; text-align: center; border-top-right-radius: 5px; border-bottom-right-radius: 5px; padding-bottom: 5px;">
                        <span>{{ $product_data_value->prd_total_amount_format }}</span>
                      </td>
                    </tr>
                    @php
                    $serialNumber++;
                    @endphp
                    @endforeach

                  </tbody>
                  <tfoot>
                    <tr style="line-height: 20px !important; height: auto;">
                    <!-- Grand Total -->
                      <th colspan="4"></th>
                      <th colspan="2" style="font-weight: bold; background-color: #000; color: #FFF; text-align:center; border-right: 1px solid #FFF; border-top-left-radius: 5px; border-bottom-left-radius: 5px; padding-bottom: 5px;" class="fwbold">
                        Grand Total
                      </th>
                       <!-- Total Amount -->
                      <th style="font-weight: bold; background-color: #000; color: #FFF; text-align:center; border-top-right-radius: 5px; border-bottom-right-radius: 5px; padding-bottom: 5px;" class="fwbold">
                        <b>@foreach ($invoice_data as
                          $invoice_data_value) {{ $invoice_data_value->total_amount_format }}
                          @endforeach</b>
                      </th>
                    </tr>
                    <tr>
                       <!-- Grand Total in words -->
                      <th colspan="7" style="line-height:20px; padding-bottom: 5px; padding-right: 5px; background-color: #FFF; text-align:left; text-transform:capitalize; border: 1px solid #000; padding-left: 5px; border-radius: 5px; font-weight: normal;">
                        <span class="fwbold">Grand Total in words :</span> <i>{{ $ttlamt }} Only</i></th>
                    </tr>
                  </tfoot>
                </table>

              </td>
            </tr>

            <tr>
              <td colspan="2" style="width: 100%; height: 5px;"></td>
            </tr>
            <tr>
              <td style="border: 1px solid #000;text-align: left; width: 50%; border-radius: 5px 5px 5px 5px; float: left;">
                <!-- Company details section in pdf-->
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                      <table style="width: 100%;">
                        <tr>
                          <td colspan="2" style="text-decoration: underline; font-weight: bold;" class="fwbold"> Company Details </td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold; width:22%" class="fwbold">Company Type</td>
                          <td style=" text-transform: uppercase; width:78%">: MSME</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;" class="fwbold">HSN/ SAC Code</td>
                          <td style=" text-transform: uppercase;">: 998599</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;" class="fwbold">GST No</td>
                          <td style=" font-weight: normal; text-transform: uppercase;">: 36BMUPM8631E3ZJ</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;" class="fwbold">PAN No</td>
                          <td style=" text-transform: uppercase;">: BMUPM8631E</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td style="width: 48%; margin-left: 2%; float: left; margin-top: 10px; border: 1px solid #000;  border-radius: 5px 5px 5px 5px;">
                 <!-- Company details section in pdf-->
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 98%; padding-left: 2%;">
                      <table style="width: 100%;">
                        <tr>
                          <td colspan="2" style="text-decoration: underline; font-weight: bold;" class="fwbold"> Bank Details </td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold; width:28%" class="fwbold">Name</td>
                          <td style=" text-transform: uppercase; width:72%">: CELEB MEDIA</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;" class="fwbold">Bank Name</td>
                          <td style=" text-transform: uppercase;">: HDFC</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;" class="fwbold">Account No</td>
                          <td style=" text-transform: uppercase;">: 50200029001723</td>
                        </tr>
                        <tr>
                          <td style=" font-weight: bold;" class="fwbold">IFSC Code</td>
                          <td style=" text-transform: uppercase;">: HDFC1234101</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
               <!-- NOTE section in pdf-->
            <tr>
              <td colspan="2" style="width: 99%; padding-left: 1%; padding-bottom: 50px;">
                Note: All payments shall be made in favour of "<span class="fwbold">CELEB MEDIA</span>"
              </td>
            </tr>
                <!-- Signature section in pdf-->
            <tr>
              <td colspan="2" style="width: 100%; margin-top: 10px; padding-top: 10px;">
                <table style="text-align: right; width: 100%;">
                  <tr>
                    <td style="padding-right: 40px;"><span style=" border-bottom: 1px solid #000; padding: 1% 5%;">For Celeb Media</span></td>
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
    <!-- Footer section in pdf-->
  <div id="footer">
    <table style="width:100%; border-collapse: collapse;">
      <tr>
        <td colspan="3" style="clear: both; text-align: left; padding-top: 10px; padding-left:2%; padding-bottom: 10px; border-bottom: 1px solid #000;">E & O.E.</td>
      </tr>
    <!-- Company Logo part in pdf-->
      <tr>
        <td style="width:22%; padding-left:2%; text-align: center; float: left;">
          <img src="../storage/app/cm_logo.png" style="width: 150px; margin-top: 35px;">
        </td>
        <!-- Company address part in pdf-->
        <td style="width: 56%;float: left;padding-left: 10px; padding-bottom: 10px; border-right: 1px solid #f23c00;border-left: 1px solid #f23c00; line-height: 15px; margin-top: -15px;" class="class_calibri">
          <img src="../public/css/location_icon.png" style="width: 16px; height: auto; vertical-align: middle; margin-top: 15px;">
          3rd Floor, 91 Springboard, Mythri Square, Gachibowli - Miyapur Road, <br>Landmark: Opposite AMB Mall,
          Kondapur, Hyderabad, Telangana - 500084, India.<br>
          <img src="../public/css/gst_icon.png" style="width: 16px; height: auto; border: 0px;vertical-align: middle; margin-top: 15px;">
          <span class="class_calibri" style='font-weight: bold;'>GST No : 36BMUPM8631E3ZJ</span>
        </td>
        <td style="width:22%; padding-left: 10px; padding-bottom: 10px; float: left;line-height: 15px; margin-top: -10px;" class="class_calibri">
          <img src="../public/css/phone_icon.png" style="width: 16px; height: auto; padding-right: 10px; border: 0px;vertical-align: middle; margin-top: 10px;">
          +91 7036-365-247
          <br>
          <img src="../public/css/email_icon.png" style="width: 16px; height: auto; padding-right: 10px; border: 0px; vertical-align: middle; margin-top: 10px;">
          info@celebdigital.in
          <br>
          <img src="../public/css/internet_icon.png" style="width: 16px; height: auto; padding-right: 10px; border: 0px; vertical-align: middle; margin-top: 10px; image-rendering: pixelated !important; transform: translateZ(0) !important;">
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
