<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')

<!-- Page Content -->
      <!-- If Session complete. Quotation Pdf download   -->
      @if(Session::has('invoice_pdf'))
         <meta http-equiv="refresh" content="0;url={{ Session::get('invoice_pdf') }}">
      @endif

        <!-- Form Validation -->
<script>
  function validateForm() {
    var file = document.forms["campaign_form"]["file"].value;
    var context = document.getElementById("context").value;
    var caller_id = document.getElementById("caller_id").value;
    var txt_max_retry_count = document.getElementById("txt_max_retry_count").value;
    var txt_retry_time = document.getElementById("txt_retry_time").value;

    var flag = true;

    if (file == "" || context == "" || caller_id == "" || txt_max_retry_count == "" || txt_retry_time == "") {
      if (file == "") {
        var x = document.getElementById("file");
        x.style.setProperty("border-color", "red", "important");
      }
      if (context == "") {
        var x = document.getElementById("context");
        x.style.setProperty("border-color", "red", "important");
      }
      if (caller_id == "") {
        var x = document.getElementById("caller_id");
        x.style.setProperty("border-color", "red", "important");
      }
      if (txt_max_retry_count == "") {
        var x = document.getElementById("txt_max_retry_count");
        x.style.setProperty("border-color", "red", "important");
      }
      if (txt_retry_time == "") {
        var x = document.getElementById("txt_retry_time");
        x.style.setProperty("border-color", "red", "important");
      }

      flag = false;

    }
    // alert("FL:"+flag);

    if (flag) {

      // Disable the button
      document.getElementById("submit_btn").disabled = true;
      document.getElementById("submit_btn").style.backgroundColor = "gray";

      document.getElementById("cancel_btn").disabled = true;
      document.getElementById("cancel_btn").style.backgroundColor = "gray";

      document.getElementById("clear_btn").disabled = true;
      document.getElementById("clear_btn").style.backgroundColor = "gray";

      //processing message display
      var processingMsg = document.createElement("p");
      processingMsg.textContent = "Invoice creation Processing...please wait";
      processingMsg.style.fontSize = "18px";
      submit_btn.parentNode.insertBefore(processingMsg, submit_btn);
      return true;
    } else {
      return false;
    }
  }

  // Validation for data
  function validate_zero() {
    if (document.getElementById("txt_max_retry_count").value == 0) {
      document.getElementById("txt_retry_time").readOnly = true;
      document.getElementById("txt_retry_time").required = false;
      var input = document.getElementById("txt_retry_time");
      input.setAttribute("min", 0);
      document.getElementById("txt_retry_time").value = 0;
    } else {
      document.getElementById("txt_retry_time").readOnly = false;
      document.getElementById("txt_retry_time").required = true;
      var input = document.getElementById("txt_retry_time");
      input.setAttribute("min", 60);
      document.getElementById("txt_retry_time").value = 900;
    }
  }
</script>


<!-- Get the details from company and product table -->
<?php
$companies = \App\Models\Company_master::all();
$products =  \App\Models\Product_master::all();
$quotation =  \App\Models\Accounting_invoice::all();
$sales = \App\Models\Sales_team::all();
$bank = \App\Models\Bank_master::all();


$settings = \App\Models\Master_setting::all();
foreach ($settings as $settings_name) {
    if($settings_name->master_settings_id == 3) {
        $current_state = $settings_name->master_settings_value;
    }
}
?>

<style>
.badge{

  background-color:#880009;
  width:400px;
  height:50px;
  border-radius:22px;
  display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 95%;
    font-weight: 700;
    line-height: 40px;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;

}

/* Add glow effect on hover */
.neon-pink-hover {
  background-color:black !important;
  color:white !important;
}
.neon-pink-hover:hover{

  background-color:#f6d8d8 !important;
  color:black !important;
}
.removefield:hover{
  background-color:#f6d8d8 !important;
  color:black !important;
}
.addfield:hover{
  background-color:#f6d8d8 !important;
  color:black !important;
}


</style>
<!-- Container for the Generate Invoice  -->
<div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 flex flex-col">

<!-- If Session Success. This modal success popup display in page -->
@if($message = Session::get('success'))

<!-- Success pop up Starts -->

 <div class="modal fade bs-example-modal-md" id="success_msg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style=" position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 400px">
  <div class="modal-dialog modal-md">
      <div class="modal-content" id='mdl' style="min-height: 320px;">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 40px; padding: 0px; border-radius: 5px; margin-left:335px;">
        <span aria-hidden="true">x</span>
        </button>
        <center>
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 512 512" style="fill:#28a745;"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
<br>
<h3 style="color:green; font-size:22px; margin-top:10px;"><b>SUCCESS</b></h3>
<br>
        <p style="margin-top:15px;"><b>{{$message}}</b></p>
        <br>
        </center>
        <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close" style="margin-top:40px;">Close</button>
    </div>
</div>
</div>

<script>
$('#success_msg').modal('show');
</script>
<!-- Success pop up ends -->
@endif

<!-- Back button for this page. And this button redirect from Registered Clients -->
<a href="{{ route('create_invoice') }}" title="Back">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="fill: #880009; width: 24px;" width="24"><path d="M32 15H3.41l8.29-8.29-1.41-1.42-10
10a1 1 0 0 0 0 1.41l10 10 1.41-1.41L3.41 17H32z" data-name="4-Arrow Left"></path></svg>
</a>

<!-- Heading for this page -->
  <div class="mb-4 text-center text-2xl" style="color:white; font-weight:bold;"><span class="badge" style=""> Generate Invoice </div>
   <!-- This form connected to route('file-import') in web.php -->
  <form action="{{ route('form_generate_invoice') }}" method="POST" name="campaign_form" id="campaign_form" onsubmit="return validateForm()" enctype="multipart/form-data">

    @csrf

    <!-- Client Form -->

    <!-- Quotation No label and input field -->
    <div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
 
    <label class="uppercase tracking-wide text-black mb-2" for="Quotation No " style="line-height: 54px; font-weight: bold">
          Quotation No*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <select name="quota_no1" id="quota_no1" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" title="Quotation No" onchange="populateCompanyName()">
    <!-- company_name_value data display in dropdown -->
          <option value="" disabled selected>Quotation No</option>
          @foreach ($company_name_value as $company)
		@if($company['entry_status'] == 'Y')
          <option value="{{ $company['accounting_invoice_id'] }}" @if( $_SERVER['QUERY_STRING'] == $company['accounting_invoice_id'] ) selected @endif>{{ $company['quotation_sr_no'] }} </option>
		@endif
          @endforeach
        </select>
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Campaign Start Date label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Campaign Start Date" style="line-height: 54px; font-weight: bold">
          Campaign Start Date*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="start_date" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="start_date" name="start_date" title="Campaign Start Date " type="date" value="@php echo date(" Y-m-d H:i", strtotime(Config::get('app.schedule_time'))) @endphp" min="@php echo date(" Y-m-d H:i", strtotime(Config::get('app.schedule_time'))) @endphp"' max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixtodate()">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Campaign End Date label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Campaign End Date" style="line-height: 54px; font-weight: bold">
          Campaign End Date*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="end_date" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="end_date" name="end_date" title="Campaign End Date" type="date" value="@php echo date(" Y-m-d H:i", strtotime(Config::get('app.schedule_time'))) @endphp" min="@php echo date(" Y-m-d H:i", strtotime(Config::get('app.schedule_time'))) @endphp"' max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixfrmdate()">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Client Name label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Name" style="line-height: 54px; font-weight: bold"> 
          Client Name*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_name" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_name" title="Client Name" type="text" placeholder="Client Name" maxlength="50" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Client Address 1 label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address" style="line-height: 54px; font-weight: bold">
          Client Address 1*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_address" title="Client Address" type="text" placeholder="Client Address 1" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Client Address 2 label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address 2" style="line-height: 54px; font-weight: bold">
          Client Address 2*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address_2" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_address_2" title="Client Address 2" type="text" placeholder="Client Address 2" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Client Address 3 label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address" style="line-height: 54px; font-weight: bold">
          Client Address 3*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address_3" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_address_3" title="Client Address 3" type="text" placeholder="Client Address 3" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Client Address 3 label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address" style="line-height: 54px; font-weight: bold">
          Client Address 4*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address_4" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_address_4" title="Client Address 4" type="text" placeholder="Client Address 4" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>


<!-- City / District label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="City / District" style="line-height: 54px; font-weight: bold">
          City / District*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_location" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_location" title="City / District" type="text" placeholder="City / District" maxlength="50" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- State label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="State" style="line-height: 54px; font-weight: bold">
          State*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
	<input name="hd_client_state" id="hd_client_state" value="{{ $current_state }}" type="hidden">
    <input name="quota_client_state" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_state" title="State" type="text" placeholder="State" maxlength="30" minlength="1" >
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Pin Code label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Pin Code" style="line-height: 54px; font-weight: bold">
          Pin Code*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_pincode" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_pincode" title="Pin Code" type="text" placeholder="Pin Code" maxlength="6" minlength="1" >
      </div>
    <div class="col-2">
    </div>
</div>

<!-- GST Number label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="GST Number" style="line-height: 54px; font-weight: bold">
       GST Number*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_gst" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" id="quota_client_gst" title="GST Number" type="text" placeholder="Gst Number" maxlength="30" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

  <!-- Primary Contact User label and input field -->
   
  <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Primary Contact User" style="line-height: 54px;font-weight: bold; color:black;">
          Primary Contact Name*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="quota_company_contact_user" id="quota_company_contact_user" placeholder="Contact Name (Primary)" style="" title="Primary Contact User" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly"required maxlength="50" minlength="1" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)"/>
        @error('company_contact_user')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!-- Primary Phone label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Primary Phone" style="line-height: 54px;font-weight: bold; color:black;">
          Primary Phone*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="quota_company_phone" id="quota_company_phone" placeholder="Phone Number (Primary)" style="" title="Primary Phone" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
        <div id="phone_error" class="error hidden">Please enter a valid phone number</div>
        @error('company_phone')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!--  Primary Email label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3  px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Primary Email" style="line-height: 54px; font-weight: bold; color:black;">
          Primary Email*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="email" name="quota_company_email" id="quota_company_email" placeholder="Email Address (Primary)" style="" title="Primary Email" readonly class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" required maxlength="50" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
        @error('email')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

  <!--  Secondary Contact User label and input field -->
  
  <div id="contact_container">
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Contact User" style="line-height: 54px; font-weight: bold; color:black;">
          Secondary Contact Name
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="quota_contact_person_secondary[]" id="quota_contact_person_secondary" placeholder="Contact Name (Secondary)" title="Secondary Contact User" readonly style="" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" maxlength="50" minlength="1" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)" />
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      <!-- <input type="button" class="btn btn-success" id="addContactButton" value="ADD"> -->
      </div>
    </div>


      <!-- Secondary Contact Phone label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3  px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Contact Phone" style="line-height: 54px; font-weight: bold; color:black;">
          Secondary Contact Phone
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="quota_contact_no_secondary[]" id="quota_contact_no_secondary" placeholder="Contact Phone (Secondary)" title="Secondary Contact Phone" readonly style="" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!-- Secondary Email label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Email" style="line-height: 54px; font-weight: bold; color:black;">
          Secondary Email
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="email" name="quota_company_email_secondary[]" id="quota_company_email_secondary" readonly placeholder="Email Address (Secondary)" title="Secondary Email" style="" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" maxlength="30" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>
</div>

     <!--  Bank Name label and input field -->
  <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Bank Name" style="line-height: 54px; font-weight: bold;  color:black;">
        Bank Name*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <select name="quota_bank_name" id="quota_bank_name" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" title="State">
          <option value="" disabled selected>-- Choose Bank --</option>
          @foreach ($bank as $bank_details)
                  <option value="{{ $bank_details->bank_master_id }}">{{ $bank_details->bank_name }} </option>
          @endforeach
        </select>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

<!-- Purchase Order Availability label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="title" style="line-height: 54px; font-weight: bold">
          Purchase Order Availability
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0" style="padding-top: 18px;">
	<input type="radio" name="po_available" id="po_available" value="Y" onclick="func_open_pono('Y')" checked="checked"> Yes <input type="radio" name="po_available" id="po_available" value="N" onclick="func_open_pono('N')"> No
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Purchase Order No label and input field -->
<div class="row flex mb-6 mt-2" id="id_open_pono">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="title" style="line-height: 54px; font-weight: bold">
          Purchase Order No*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="purchase_order_no" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="purchase_order_no" title="Purchase Order No" type="text" placeholder="Purchase Order No" maxlength="15" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<!-- Upload File label and input field -->
<div class="row flex mb-6 mt-2" id="id_open_pofile">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="user_avatar" style="line-height: 54px; font-weight: bold">Upload File*</label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="po_attachment" type="file" name="po_attachment" title="Upload PDF file" required  accept="application/pdf, .pdf">
      </div>
    <div class="col-2">
    </div>
</div>


    <!-- Remarks label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Remarks" style="line-height: 54px; font-weight: bold;">
         Remarks
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_remarks" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="quota_remarks" title="Remarks 1" type="text" placeholder="1. Enter Your Remarks Here" maxlength="150">
      </div>
    <div class="col-2">
</div>
</div>


   <!-- Remarks label and input field -->
    <div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_remarks_2" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="quota_remarks_2" title="Remarks 2" type="text" placeholder="2. Enter Your Remarks Here" maxlength="150">
      </div>
    <div class="col-2">
</div>
</div>

           <!-- Submitted By label and input field -->
    <div class="row flex mb-6 mt-2"> 
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Submit By" style="line-height: 54px; font-weight: bold">
          Submitted By*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <select name="quota_submitted_name" id="quota_submitted_name" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" title="State">
          <option value="" disabled selected>-- Choose name --</option>
          @foreach ($sales as $sales_name)
                  <option value="{{ $sales_name->sales_team_user }}">{{ $sales_name->sales_team_user }} </option>
          @endforeach
        </select>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

 

    <!-- Product Form -->

    <div class="mb-4 text-center text-2xl mt-4" style="color:white; font-weight:bold">
     <span class="badge" style=""> Activity Details
    </div>

    @csrf

    <div id="fields-container">
      <div class="field-row">
        <div class="">
          <div class="">

            <table class="table table-bordered" id="dynamicTable">
              <!-- serial number  -->
              <tr style="height:17pt; font-weight: bold">
                <td style="width:5%;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="">
                  <p class="s6" style="padding-top: 2pt;padding-left: 21pt;padding-right: 20pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
                    S.No</p>
                </td>
                 <!-- Particulars  -->
                <td style="width:32%;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="">
                  <p class="s6" style="padding-top: 1pt;padding-left: 92pt;padding-right: 92pt;text-indent: 0pt;text-align: center;">
                    Particulars</p>
                </td>
                 <!-- Quantity  -->
                <td style="width:13%;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="">
                  <p class="s6" style="padding-top: 2pt;padding-left: 18pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
                    Quantity</p>
                     <!-- Rate  -->
                </td>
                <td style="width:13%;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="">
                  <p class="s6" style="padding-top: 2pt;padding-left: 6pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
                    Rate</p>
                    <!-- Amount  -->
                </td>
                <td style="width:15%;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="">
                  <p class="s6" style="padding-top: 2pt;padding-left: 6pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
                    Amount</p>
                     <!-- GST  -->
                </td>
                <td style="width:8%;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="">
                  <p class="s6" style="padding-top: 2pt;padding-left: 6pt;text-indent: 0pt;line-height: 13pt;text-align: center;" id="id_igst_csgst">
                    IGST</p>
                    <!--  Total Amount  -->
                </td>
                <td style="width:20%; border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="">
                  <p class="s6" style="padding-top: 2pt;padding-left: 18pt;text-indent: 0pt;line-height: 13pt;text-align: center;">
                    Total Amount</p>
                </td>
              </tr>

              <tbody id="id_product_data">

              </tbody>

              <tr style="height:16pt">
                <td colspan="6" style="width:435pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="4">
                  <p class="s2" style="padding-top: 2pt;padding-left: 289pt;text-indent: 0pt;line-height: 12pt;text-align: right;">
                    Grand Total Amount in Rs.</p>
                </td>
                <td style="width:107pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                  <p class="s2" id="product_total" style="padding-top: 2pt;padding-right: 5pt;text-indent: 0pt;line-height: 12pt;text-align: right;">
                  </p>
                </td>
              </tr>

            </table>

          </div>
        </div>
      </div>
    </div>

    <!-- Alert message for session success -->
    <div class="-x-3 md:flex mb-6">
      @if(Session::has('message'))
      <div class="alert {{ Session::get('alert-class') }}" role="alert">
        {{ Session::get('message') }}
      </div>
      @endif
    </div>

    <div class="-   mx-3 md:flex mb-6">
      <div class="md:w-1/2 px-3 mb-4 md:mb-0">
         <!-- Clear button for Genrate invoice page -->
        <a href="{{ route('generate_invoice') }}">
          <button type="button" id="clear_btn" class="neon-pink-hover md:w-full mt-7  text-white py-2 px-4 rounded-full" style="font-weight:bold; background-color:black; !important font-size: 1.1rem;" title="CLEAR">
            Clear
          </button></a>
      </div>
      <div class="md:w-1/2 px-3 mb-4 md:mb-0">
        <!-- Form submit button for generate invoice page -->
        <input type="hidden" name='hid_prdqty' id='hid_prdqty' value=''>
        <input type="hidden" name='hid_prdrate' id='hid_prdrate' value=''>
        <input type="hidden" name='hid_prdgstpercentage' id='hid_prdgstpercentage' value=''>
        <input type="hidden" name='hid_prdgstamount' id='hid_prdgstamount' value=''>
        <input type="hidden" name='hid_prdtotalamount' id='hid_prdtotalamount' value=''>

        <button type="submit" name="submit_btn" id="submit_btn" class="neon-pink-hover md:w-full mt-7 text-white py-2 px-4 rounded-full" style="background-color:black; !important; font-weight:bold; font-size: 1.1rem;" title="SUBMIT">
          Submit
        </button>
      </div>
      <div class="md:w-1/2 px-3 mb-4 md:mb-0">
        <!-- Cancel button for Genrate invoice page -->
        <a href="{{ route('create_invoice') }}">
          <button type="button" id="cancel_btn" class="neon-pink-hover md:w-full mt-7 text-white py-2 px-4 rounded-full" style="font-weight:bold; background-color:black; !important font-size: 1.1rem;" title="CANCEL">
            Cancel
          </button></a>
      </div>
    </div>

  </form>

</div>

<!-- Campaign date validation -->
<script>
function func_fixtodate() {
        var frmdate = $("#start_date").val();
        $('#end_date').attr('min', frmdate);
}

function func_fixfrmdate() {
        var todate = $("#end_date").val();
        $('#start_date').attr('max', todate);
}

// Purchase order availability script
function func_open_pono(availablity) {
	if(availablity == 'Y') {
		$("#purchase_order_no").val('');
		$("#purchase_order_no").prop('required', true);
                $("#po_attachment").prop('required', true);

		$("#id_open_pono").show();
                $("#id_open_pofile").show();
	} else { 
		$("#purchase_order_no").val('-');
		$("#purchase_order_no").prop('required', false);
		$("#po_attachment").prop('required', false);
		$("#id_open_pono").hide();
                $("#id_open_pofile").hide();
	}
}

  $(document).ready(function() {
    $('#quota_no1').change(function() {
    });
  });

  // Populate values in fields
   function populateCompanyName() {
      let quotation_no = $('#quota_no1').val();
      console.log(quotation_no);
      let url = '{{ route("ajax_generate_invoice", ":quotation_no") }}';
      url = url.replace(':quotation_no', quotation_no);

      $.ajax({
        url: url,
        type: 'GET', // Change the request type to GET
        dataType: 'json',
        success: function(response) {
          if (response.company_data && response.product_data && response.invoice_data && response.contact_data && response.contact_data2) {

            comapanyData = response.company_data;
            productData = response.product_data;
            invoiceData = response.invoice_data;
	    contactData = response.contact_data;
            contactData2 = response.contact_data2;

            let serialNumber = 1;
            // Get data
            $('#quota_client_name').val(comapanyData[0].company_name);
            $('#quota_client_address').val(invoiceData[0].company_address);
            $('#quota_client_address_2').val(invoiceData[0].company_address_2);
            $('#quota_client_address_3').val(invoiceData[0].company_address_3);
            $('#quota_client_address_4').val(invoiceData[0].company_address_4);
            $('#quota_client_location').val(invoiceData[0].company_location);
            $('#quota_client_state').val(invoiceData[0].company_state);
		var clistat = document.getElementById("hd_client_state").value;
		if(clistat == invoiceData[0].company_state) {
		        $('#id_igst_csgst').html('CGST/SGST');
		} else {
			$('#id_igst_csgst').html('IGST');
    		}

            $('#quota_client_pincode').val(invoiceData[0].company_pincode);
            $('#quota_client_gst').val(comapanyData[0].gst_no);
	    $('#quota_bank_name').val(invoiceData[0].bank_master_id);
	    $('#quota_submitted_name').val(invoiceData[0].quotation_submitted_by);
	    $('#quota_remarks').val(invoiceData[0].quotation_remarks);
	    $('#quota_remarks_2').val(invoiceData[0].quotation_remarks_2);
	    $('#quota_company_contact_user').val(contactData[0].contact_name);
	    $('#quota_company_phone').val(contactData[0].contact_mobile);
	    $('#quota_company_email').val(contactData[0].contact_email);

	  let contactCounter = 1;
            $('#contact_container').html("");

            contactData2.forEach(function(contact, index) {
            
                // Activity Details data content
              let rowHtml = `
              <div class="row flex mb-6 mt-2">
            <div class="col-3">
            </div>
            <div class="col-3  px-3 mb-6 md:mb-0">
                <label class="uppercase tracking-wide text-black mb-2" for="Submit By" style="line-height: 54px; font-weight: bold; color:white;">
                    Secondary Contact Name ${contactCounter}
                </label>
            </div>
            <div class="col-3 px-3 mb-6 md:mb-0">
                <input type="text" name="quota_contact_person_secondary[]" id="quota_contact_person_secondary_${index}" placeholder="Contact Name (Secondary)" title="Secondary Contact User" readonly style="background-color:#D3D3D3 !important;" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" maxlength="50" minlength="1" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)" />
                @error('')
                <p class="text-red-500 text-xs italic mt-4">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-3">
            </div>
        </div>

      <div class="row flex mb-6 mt-2">
      <div class="col-3">
      </div>
      <div class="col-3  px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Contact Phone" style="line-height: 54px; font-weight: bold; color:white;">
          Secondary Contact Phone ${contactCounter}
        </label>
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <input type="text" name="quota_contact_no_secondary[]" id="quota_contact_no_secondary_${index}" placeholder="Contact Phone (Secondary)" title="Secondary Contact Phone" readonly style="background-color:#D3D3D3 !important;" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-3">
      </div>
    </div>

    <div class="row flex mb-6 mt-2">
      <div class="col-3">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Email" style="line-height: 54px; font-weight: bold; color:white;">
          Secondary Email ${contactCounter}
        </label>
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <input type="email" name="quota_company_email_secondary[]" id="quota_company_email_secondary_${index}" readonly placeholder="Email Address (Secondary)" title="Secondary Email" style="background-color:#D3D3D3 !important;" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 rdonly" maxlength="30" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-3">
      </div>
    </div>

      `;

              $('#contact_container').append(rowHtml);

              contactCounter++;

            });

            // Iterate through the contactData2 array and populate input fields
            for (let i = 0; i < contactData2.length; i++) {
            $('#quota_contact_person_secondary_' + i).val(contactData2[i].contact_name);
            $('#quota_contact_no_secondary_' + i).val(contactData2[i].contact_mobile);
            $('#quota_company_email_secondary_' + i).val(contactData2[i].contact_email);
            // ... add more lines here to populate other fields
             } 


 
           $('#id_product_data').html("");

            productData.forEach(function(product) {
                // Activity Details data content
              let rowHtml = '<tr>' +
                '<td style="width:80pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;text-align:center">' + serialNumber + '</td>' +
                '<td style="width:276pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt">' + product.product_master_name + '</td>' +
                '<td style="width:90pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt; text-align: right;">' + product.prd_qty + '</td>' +
                '<td style="width:60pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;  text-align: right;">' + product.product_rate + '</td>' +
                '<td style="width:60pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;  text-align: right;">' + product.prd_subtotal_amount + '</td>' +
                '<td style="width:60pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;  text-align: right;">' + product.prd_gst_amount + '</td>' +
                '<td style="width:105pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;  text-align: right;">' + product.prd_total_amount + '</td>' +

                '</tr>';

              $('#id_product_data').append(rowHtml);

              serialNumber++;
            });

            $('#product_gst').html(invoiceData[0].gst_amount);
            $('#product_total').html(invoiceData[0].total_amount);

          }
	
	                // Initialize select2
$("#quota_submitted_name").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#quota_submitted_name').click(function(){
     var username = $('#submitted_name option:selected').text();
 })

         // Initialize select2
$("#quota_bank_name").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#quota_bank_name').click(function(){
     var username = $('#quota_bank_name option:selected').text();
 })
	
        },

      });
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>

$(document).ready(function(){ // Search bar filter for selected quotation no dropdown
 
 // Initialize select2
 $("#quota_no1").select2();

 // Read selected option
 $('#quota_no1').click(function(){
     var username = $('#quota_no1 option:selected').text();
     var userid = $('#quotation_no').val();

 });

      // Initialize select2
$("#quota_submitted_name").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#quota_submitted_name').click(function(){
     var username = $('#submitted_name option:selected').text();
 });

         // Initialize select2
$("#quota_bank_name").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#quota_bank_name').click(function(){
     var username = $('#quota_bank_name option:selected').text();
 });

});

window.onload = function() {
  var a = location.href;
  var b = a.substring(a.indexOf("?")+1);

  if(b != '') {
    populateCompanyName()
  }
}

$('body').click(function (event)
{
   if(!$(event.target).closest('#success_msg').length && !$(event.target).is('#success_msg')) {
        $('#success_msg').modal('hide');
   }
});
</script>

@endsection


