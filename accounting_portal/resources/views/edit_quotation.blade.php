<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@extends('layouts.app')
@section('content')
      @if(Session::has('invoice_pdf'))
         <meta http-equiv="refresh" content="0;url={{ Session::get('invoice_pdf') }}">
      @endif

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

  function updateRate(id_prd) {
    var quantity = parseFloat(document.getElementById("invoice_quality_" + id_prd).value);
    var rate = parseFloat(document.getElementById("invoice_rate_" + id_prd).value);
    var gst = parseFloat(document.getElementById("invoice_gst_" + id_prd).value);

    var rate_value = parseFloat(rate) * parseFloat(quantity);
    var total_value = parseFloat(rate_value) + (parseFloat(rate_value) * parseFloat(gst) / 100);

    document.getElementById("invoice_total_" + id_prd).value = total_value.toFixed(2);

    call_total();
  }
</script>

<script>

    let contactCounter = ' ' + 1 ; 

    function addContactField() {
 
 var hid_count = document.getElementById('contact_hid_count').value;
 var contactBody = document.getElementById('contact_container');

 // Secondary Contact Name
 var newRowName = document.createElement('div');
 newRowName.classList.add('row', 'flex', 'mb-6', 'mt-2');

 var col1Name = document.createElement('div');
 col1Name.classList.add('col-3');
 newRowName.appendChild(col1Name);

 var col2Name = document.createElement('div');
 col2Name.classList.add('col-3', 'px-3', 'mb-6', 'md:mb-0');
 var nameLabel = document.createElement('label');
 nameLabel.classList.add('uppercase', 'tracking-wide', 'text-black', 'mb-2');
 nameLabel.style.fontWeight = 'bold'; // Apply bold style
 nameLabel.style.color = 'black'; // Apply white color
 nameLabel.style.lineHeight = '54px';
 nameLabel.textContent = 'Secondary Contact Name ' + contactCounter;
 col2Name.appendChild(nameLabel);
 newRowName.appendChild(col2Name);

 var col3Name = document.createElement('div');
 col3Name.classList.add('col-3');
 var nameInput = document.createElement('input');
 nameInput.type = 'text';
 nameInput.name = 'quota_contact_person_secondary[]';
 nameInput.id = 'quota_contact_person_secondary_' + hid_count;
 nameInput.placeholder = 'Contact Name (Secondary) '+ contactCounter;
 nameInput.title = 'Secondary Contact User ' + contactCounter;
 nameInput.classList.add('w-full', 'mt-2', 'py-3', 'px-4', 'border', 'border-gray-300', 'rounded', 'block', 'appearance-none', 'placeholder-gray-500', 'focus:outline-none', 'focus:bg-white');
 nameInput.maxLength = '50';
 nameInput.minLength = '1';
 nameInput.onkeypress = function(event) {
     return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32);
 };
 col3Name.appendChild(nameInput);
 newRowName.appendChild(col3Name);

 var col4Name = document.createElement('div');
 col4Name.classList.add('col-3');
 newRowName.appendChild(col4Name);

 contactBody.appendChild(newRowName);

 // Secondary Contact Phone
 var newRowPhone = document.createElement('div');
 newRowPhone.classList.add('row', 'flex', 'mb-6', 'mt-2');

 var col1Phone = document.createElement('div');
 col1Phone.classList.add('col-3');
 newRowPhone.appendChild(col1Phone);

 var col2Phone = document.createElement('div');
 col2Phone.classList.add('col-3', 'px-3', 'mb-6', 'md:mb-0');
 var phoneLabel = document.createElement('label');
 phoneLabel.classList.add('uppercase', 'tracking-wide', 'text-black', 'mb-2');
 phoneLabel.style.fontWeight = 'bold'; // Apply bold style
 phoneLabel.style.color = 'black'; // Apply white color
 phoneLabel.style.lineHeight = '54px';
 phoneLabel.textContent = 'Secondary Contact Phone ' + contactCounter;
 col2Phone.appendChild(phoneLabel);
 newRowPhone.appendChild(col2Phone);

 var col3Phone = document.createElement('div');
 col3Phone.classList.add('col-3');
 var phoneInput = document.createElement('input');
 phoneInput.type = 'text';
 phoneInput.name = 'quota_contact_no_secondary[]';
 phoneInput.id = 'quota_contact_no_secondary_' + hid_count;
 phoneInput.placeholder = 'Contact Phone (Secondary) ' + contactCounter;
 phoneInput.title = 'Secondary Contact Phone ' + contactCounter;
 phoneInput.classList.add('w-full', 'mt-2', 'py-3', 'px-4', 'border', 'border-gray-300', 'rounded', 'block', 'appearance-none', 'placeholder-gray-500', 'focus:outline-none', 'focus:bg-white');
 phoneInput.onkeypress = function(event) {
     return (event.charCode != 8 && event.charCode == 0 || (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)));
 };
 phoneInput.maxLength = '10';
 col3Phone.appendChild(phoneInput);
 newRowPhone.appendChild(col3Phone);

 var col4Phone = document.createElement('div');
 col4Phone.classList.add('col-3');
 newRowPhone.appendChild(col4Phone);

 contactBody.appendChild(newRowPhone);

 // Secondary Email
 var newRowEmail = document.createElement('div');
 newRowEmail.classList.add('row', 'flex', 'mb-6', 'mt-2');

 var col1Email = document.createElement('div');
 col1Email.classList.add('col-3');
 newRowEmail.appendChild(col1Email);

 var col2Email = document.createElement('div');
 col2Email.classList.add('col-3', 'px-3', 'mb-6', 'md:mb-0');
 var emailLabel = document.createElement('label');
 emailLabel.classList.add('uppercase', 'tracking-wide', 'text-black', 'mb-2');
 emailLabel.style.fontWeight = 'bold'; // Apply bold style
 emailLabel.style.color = 'black'; // Apply white color
 emailLabel.style.lineHeight = '54px';
 emailLabel.textContent = 'Secondary Email ' + contactCounter;
 col2Email.appendChild(emailLabel);
 newRowEmail.appendChild(col2Email);

 var col3Email = document.createElement('div');
 col3Email.classList.add('col-3');
 var emailInput = document.createElement('input');
 emailInput.type = 'email';
 emailInput.name = 'quota_company_email_secondary[]';
 emailInput.id = 'quota_company_email_secondary_' + hid_count;
 emailInput.placeholder = 'Email Address (Secondary) ' + contactCounter;
 emailInput.title = 'Secondary Email ' + contactCounter;
 emailInput.classList.add('w-full', 'mt-2', 'py-3', 'px-4', 'border', 'border-gray-300', 'rounded', 'block', 'appearance-none', 'placeholder-gray-500', 'focus:outline-none', 'focus:bg-white');
 emailInput.maxLength = '30';
 emailInput.minLength = '1';
 emailInput.pattern = '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$';
 col3Email.appendChild(emailInput);
 newRowEmail.appendChild(col3Email);

 var col4Email = document.createElement('div');
 col4Email.classList.add('col-3');
 newRowEmail.appendChild(col4Email);

 contactBody.appendChild(newRowEmail);

 hid_count = +hid_count + 1;
 document.getElementById('contact_hid_count').value = hid_count;

 contactCounter++;
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

</style>
<div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 flex flex-col">

@if($message = Session::get('success'))

<!-- Success pop up Starts -->

 <div class="modal fade bs-example-modal-md" id="success_msg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style=" position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 400px">
  <div class="modal-dialog modal-md">
      <div class="modal-content" id='mdl' style="min-height: 320px;">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 40px; padding: 0px; border-radius: 5px; margin-left:335px;">
        <span aria-hidden="true">x</span>
        </button>
        <center>
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16" style="margin-top:25px;">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
</svg>
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

<a href="{{ route('summary_list') }}" title="Back">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="fill: #880009; width: 24px;" width="24"><path d="M32 15H3.41l8.29-8.29-1.41-1.42-10 10a1 1 0 0 0 0 1.41l10 10 1.41-1.41L3.41 17H32z" data-name="4-Arrow Left"/></svg>
</a>

  <div class="mb-4 text-center text-2xl" style="color:white; font-weight:bold;"><span class="badge" style=""> Edit Quotation</div>
  <form action="{{ route('edit_quotation') }}" method="POST" name="edit_quot_form" id="edit_quot_form" onsubmit="return validateForm()" enctype="multipart/form-data">

    @csrf

    <!-- Client Form -->

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
          <option value="" disabled selected>Quotation No</option>
          @foreach ($quotation as $company)
        @if ($company->entry_status !== 'E' && $company->invoice_sr_no === null)
            <option value="{{ $company['accounting_invoice_id'] }}" @if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] == $company['accounting_invoice_id']) selected @endif>{{ $company['quotation_sr_no'] }}</option>
        @endif
    @endforeach
        </select>
      </div>
    <div class="col-2">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Name" style="line-height: 54px; font-weight: bold"> 
          Client Name*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_name"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_name" title="Client Name" type="text" placeholder="Client Name" maxlength="50" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address" style="line-height: 54px; font-weight: bold">
          Client Address 1*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_address" title="Client Address" type="text" placeholder="Client Address 1" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address 2" style="line-height: 54px; font-weight: bold">
          Client Address 2*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address_2"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_address_2" title="Client Address 2" type="text" placeholder="Client Address 2" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address" style="line-height: 54px; font-weight: bold">
          Client Address 3*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address_3"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_address_3" title="Client Address 3" type="text" placeholder="Client Address 3" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Client Address" style="line-height: 54px; font-weight: bold">
          Client Address 4*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_address_4"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_address_4" title="Client Address 4" type="text" placeholder="Client Address 4" maxlength="250" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="City / District" style="line-height: 54px; font-weight: bold">
          City / District*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_location"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_location" title="City / District" type="text" placeholder="City / District" maxlength="50" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

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
    <input name="quota_client_state"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_state" title="State" type="text" placeholder="State" maxlength="30" minlength="1" >
      </div>
    <div class="col-2">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="Pin Code" style="line-height: 54px; font-weight: bold">
          Pin Code*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_pincode"  class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " id="quota_client_pincode" title="Pin Code" type="text" placeholder="Pin Code" maxlength="6" minlength="1" >
      </div>
    <div class="col-2">
    </div>
</div>

<!--  Particulars label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="title" style="line-height: 54px; font-weight: bold;">
          Particulars*
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_particulars" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="quota_client_particulars" title="Particulars" type="text" placeholder="Particulars" maxlength="100" minlength="1">
      </div>
    <div class="col-2">
    </div>
</div>

<!--  Material Code label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-2">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
    <label class="uppercase tracking-wide text-black mb-2" for="title" style="line-height: 54px; font-weight: bold;">
          Material Code
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0">
    <input name="quota_client_material" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="quota_client_material" title="Material Code" type="text" placeholder="Material code" maxlength="50" minlength="1">
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
       <input type="hidden" name="h_primary_acc_inv_contact_id" id="h_primary_acc_inv_contact_id" value="">
        <input type="text" name="quota_company_contact_user" id="quota_company_contact_user" placeholder="Contact Name (Primary)" title="Primary Contact User" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="50" minlength="1"onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)"/>
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
        <input type="text" name="quota_company_phone" id="quota_company_phone" placeholder="Phone Number (Primary)" title="Primary Phone" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
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
        <input type="email" name="quota_company_email" id="quota_company_email" placeholder="Email Address (Primary)" title="Primary Email" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="50" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
        @error('email')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2" style="display: none;">
      <button id="add-field" onclick="addContactField()" type="button" class="md:w-full text-white py-2 px-4 rounded-full addfield" style="background-color:black; width: 100px; text-align: center;" title="Add Seconday Contact"> + </button> <input type="hidden" name='contact_hid_count' id='contact_hid_count' value='1'>
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
        <input type="text" name="quota_contact_person_secondary[]" id="quota_contact_person_secondary" placeholder="Contact Name (Secondary)" title="Secondary Contact User" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" maxlength="50" minlength="1" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)" />
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
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
        <input type="text" name="quota_contact_no_secondary[]" id="quota_contact_no_secondary" placeholder="Contact Phone (Secondary)" title="Secondary Contact Phone" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
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
        <input type="email" name="quota_company_email_secondary[]" id="quota_company_email_secondary" placeholder="Email Address (Secondary)" title="Secondary Email" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" maxlength="30" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
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
          Quotation Type
        </label>
    </div>
    <div class="col-5 px-3 mb-6 md:mb-0" style="padding-top: 18px;">
	<input type="radio" name="quot_type" id="quot_type" value="P"  checked="checked"> Professional <input type="radio" name="quot_type" id="quot_type" value="A" > Amateur
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
     <span class="badge" style=""> Edit Activity 
    </div>

    @csrf

    <div id="fields-container">
      <div class="field-row">
        <div class="">
          <div class="">

          <table class="table table-bordered" id="dynamicTable">
                <tr  style=" font-weight: bold;">
                  <th style="width: 5%;">Sr.No</th>
                  <th style="width: 32%;">Product Name</th>
                  <th style="width: 15%;">Quantity</th>
                  <th style="width: 15%;">Rate</th>
                  <th style="width: 8%;" id="id_igst_csgst">GST</th>
                  <th style="width: 20%;">Total</th>
                  <!-- <th></th> -->
                </tr>
		<tbody id="field-row_tbody">

		</tbody>
              </table>

          </div>
        </div>
      </div>
    </div>


    <div class="-x-3 md:flex mb-6">
      @if(Session::has('message'))
      <div class="alert {{ Session::get('alert-class') }}" role="alert">
        {{ Session::get('message') }}
      </div>
      @endif
    </div>

    <div class="-   mx-3 md:flex mb-6">
      <div class="md:w-1/2 px-3 mb-4 md:mb-0">
        <a href="{{ route('edit_quotation') }}">
          <button type="button" id="clear_btn" class="neon-pink-hover md:w-full mt-7  text-white py-2 px-4 rounded-full" style="font-weight:bold; background-color:black; !important font-size: 1.1rem;" title="CLEAR">
            Clear
          </button></a>
      </div>
      <div class="md:w-1/2 px-3 mb-4 md:mb-0">
        <input type="hidden" name='hid_prdqty' id='hid_prdqty' value=''>
        <input type="hidden" name='hid_prdrate' id='hid_prdrate' value=''>
        <input type="hidden" name='hid_prdgstpercentage' id='hid_prdgstpercentage' value=''>
        <input type="hidden" name='hid_prdgstamount' id='hid_prdgstamount' value=''>
        <input type="hidden" name='hid_prdtotalamount' id='hid_prdtotalamount' value=''>
        <input type="hidden" name="quot_accounting_invoice_id" id="quot_accounting_invoice_id" class="form-control" value="">
        <button type="submit" name="submit_btn" id="submit_btn" class="neon-pink-hover md:w-full mt-7 text-white py-2 px-4 rounded-full" style="background-color:black; !important; font-weight:bold; font-size: 1.1rem;" title="SUBMIT">
          Submit
        </button>
      </div>
      <div class="md:w-1/2 px-3 mb-4 md:mb-0">
        <a href="{{ route('summary_list') }}">
          <button type="button" id="cancel_btn" class="neon-pink-hover md:w-full mt-7 text-white py-2 px-4 rounded-full" style="font-weight:bold; background-color:black; !important font-size: 1.1rem;" title="CANCEL">
            Cancel
          </button></a>
      </div>
    </div>


</div>


<script>
function func_fixtodate() {
        var frmdate = $("#start_date").val();
        $('#end_date').attr('min', frmdate);
}

function func_fixfrmdate() {
        var todate = $("#end_date").val();
        $('#start_date').attr('max', todate);
}

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
            $('#quota_client_particulars').val(invoiceData[0].activity_details);
            $('#quota_client_material').val(invoiceData[0].material_code);
            $('#quota_client_gst').val(comapanyData[0].gst_no);
	    $('#quota_bank_name').val(invoiceData[0].bank_master_id);
	    $('#quota_submitted_name').val(invoiceData[0].quotation_submitted_by);
	    $('#quot_type').val(invoiceData[0].quotation_type);
	    $('#quota_remarks').val(invoiceData[0].quotation_remarks);
	    $('#quota_remarks_2').val(invoiceData[0].quotation_remarks_2);
	    $('#quota_company_contact_user').val(contactData[0].contact_name);
	    $('#quota_company_phone').val(contactData[0].contact_mobile);
	    $('#quota_company_email').val(contactData[0].contact_email);
	    $('#h_primary_acc_inv_contact_id').val(contactData[0].acc_inv_contact_id);

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
                <input type="hidden" name="h_acc_inv_contact_id[]" id="h_acc_inv_contact_id_${index}" value="">
                <input type="text" name="quota_contact_person_secondary[]" id="quota_contact_person_secondary_${index}" placeholder="Contact Name (Secondary)" title="Secondary Contact User" style="background-color:" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " maxlength="50" minlength="1" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)" />
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
        <input type="text" name="quota_contact_no_secondary[]" id="quota_contact_no_secondary_${index}" placeholder="Contact Phone (Secondary)" title="Secondary Contact Phone"  style="background-color:" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
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
        <input type="email" name="quota_company_email_secondary[]" id="quota_company_email_secondary_${index}"  placeholder="Email Address (Secondary)" title="Secondary Email" style="background-color:" class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3 " maxlength="30" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
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
            $('#h_acc_inv_contact_id_' + i).val(contactData2[i].acc_inv_contact_id);
            // alert(contactData2[i].acc_inv_contact_id);
            $('#quota_contact_no_secondary_' + i).val(contactData2[i].contact_mobile);
            $('#quota_company_email_secondary_' + i).val(contactData2[i].contact_email);
            
            // ... add more lines here to populate other fields
             } 


            $('#id_product_data').html("");

            var hid_count = 0;
            productData.forEach(function(product) {
              let text = product.product_master_id;
              console.log("++"+parseInt(text)+"++");
              // let result_prdid = text.replace(/^\s+|\s+$/gm,'');
              hid_count++;
              let rowHtml = `<tr>` +
                `<td style="width:80pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;text-align:center">` + serialNumber + `</td>` +
                `<td style="width:90pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt; text-align: right;"><select name="invoice_product_name[]" id="invoice_product_name_` + hid_count + `" onchange="populateProductName(` + hid_count + `)" required class="text-black border border-gray-200 rounded py-3 px-4 mb-3 invoice_product_name_list" maxlength="100" minlength="1" style="width: 100%">
        @foreach ($product_name as $product)
                    <option value="{{ $product['product_master_id'] }}">{{ $product['product_master_name'] }}</option>
                @endforeach
        </select></td>` +
                `<td style="width:276pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt"><input name="invoice_quality[]" onchange="updateRate(` + hid_count + `)" required
            class="text-black border border-gray-200 rounded py-3 px-4 mb-3 cls_prdqty" id="invoice_quality_` + hid_count + `" title="Context & Campaign name auto generated"
            type="number" style="width: 100%" placeholder="Quantity" max="999999999999" min="1" value="`+product.prd_qty+`"></td>` +
                `<td style="width:90pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt; text-align: right;"><input name="invoice_rate[]" onchange="updateRate(` + hid_count + `)"  required
            class="text-black border border-gray-200 rounded py-3 px-4 mb-3 cls_prdrate" id="invoice_rate_` + hid_count + `" title="Context & Campaign name auto generated" type="text" style="width: 100%" placeholder="Rate" maxlength="10" minlength="1"value="` + product.product_rate + `">
            <input name="invoice_accinvprd_id[]" required
            id="invoice_accinvprd_id_` + hid_count + `" type="hidden" style="width: 100%"  placeholder="Rate" value="` + product.accinvprd_id + `">
            <input name="invoice_rate_hidden[]" onchange="updateRate(` + hid_count + `)" required
                    class="text-black border border-gray-200 rounded py-3 px-4 mb-3" id="invoice_rate_hidden_` + hid_count + `" title="Context & Campaign name auto generated"
                    type="hidden" style="width: 100%"  placeholder="Rate" ></td>` +
                `<td style="width:60pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;  text-align: right;"><input name="invoice_gst[]" onchange="updateRate(` + hid_count + `)" required
            class="text-black border border-gray-200 rounded py-3 px-4 mb-3" id="invoice_gst_` + hid_count + `" title="Context & Campaign name auto generated"
            type="number" style="width: 100%" placeholder="GST" min="0" max="99" value="` + product.prd_gst_percentage + `"></td>` +
                `<td style="width:105pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt;  text-align: right;"><input name="invoice_total[]" readonly required
            class="text-black border border-gray-200 rounded py-3 px-4 mb-3 cls_prdtotal" id="invoice_total_` + hid_count + `" title="Context & Campaign name auto generated" type="number" style="width: 100%" placeholder="Total" max="999999999999" min="1" value="` + product.prd_total_amount + `"></td>` +

                `</tr>`;

                $('#field-row_tbody').append(rowHtml);

console.log('#invoice_product_name_' + hid_count + ' option[value='+text+']');
              $('#invoice_product_name_' + hid_count + ' option[value='+text+']').attr("selected", "selected");
              // alert('#invoice_product_name_' + hid_count)
              // $('#invoice_product_name_' + hid_count).val("8");

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
     var username = $('#sumbitted_name option:selected').text();
 })

       // Initialize select2
$("#quota_bank_name").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#quota_bank_name').click(function(){
     var username = $('#quota_bank_name option:selected').text();
 });

        },

      });
    }
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>

$(document).ready(function(){
 
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
     var username = $('#sumbitted_name option:selected').text();
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

