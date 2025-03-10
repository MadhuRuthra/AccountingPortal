@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')

<!-- Get the details from State and city models -->
<?php
$state = \App\Models\Master_state::all();
$city = \App\Models\Master_cities::all();
$sales = \App\Models\Sales_team::all();
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
  border: 1px solid #000 !important;
}
.neon-pink-hover:hover{
  border: 1px solid #000 !important;
  background-color:#f6d8d8 !important;
  color:black !important;
}

</style>
<!-- Success pop up Starts -->

<!-- If Session Success. This modal success popup display in page -->
@if($message = Session::get('success'))

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

@endif

<!-- Success pop up ends -->


<div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 flex flex-col">

<!-- Heading for this page -->
  <div class="mb-4 text-center text-2xl" style="color:white; font-weight:bold"><span class="badge" style="">Register Client</div>
  <!-- This form connected to route('registercilent') in web.php -->
  <form action="{{ route('registercilent') }}" method="POST" id="register_cilent_form">
    @csrf

    <!-- client name label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Client Name" style="line-height: 54px; font-weight: bold">
          Client Name*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="name" id="name" placeholder="Client Name" title="Client Name" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="75" minlength="1" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)"/>
        @error('name')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!-- Client Address 1 label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Client Address 1" style="line-height: 54px; font-weight: bold">
          Client Address 1*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="company_address" id="company_address" title="Client Address 1" placeholder="Client Address 1" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="250" minlength="1"/>
        @error('company_address')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}

        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!-- client address 2 label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Client Address 2" style="line-height: 54px;font-weight: bold">
          Client Address 2*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="company_address_2" id="company_address_2" placeholder="Client Address 2" title="Client Address 2" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="250" minlength="1"/>
        @error('company_address')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!-- client address 3 label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for=" Client Address 3" style="line-height: 54px; font-weight: bold">
          Client Address 3*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="company_address_3" id="company_address_3" placeholder="Client Address 3" title=" Client Address 3" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="250" minlength="1"/>
        @error('company_address')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>


<!-- client address 3 label and input field -->
<div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for=" Client Address 4" style="line-height: 54px; font-weight: bold">
          Client Address 4*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="company_address_4" id="company_address_4" placeholder="Client Address 4" title=" Client Address 4" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="250" minlength="1"/>
        @error('company_address')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!-- City/ District label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="City/ District" style="line-height: 54px; font-weight: bold">
          City/ District*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
	<select name="company_location" id="company_location" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" title="City/ District">
          <option value="" disabled selected>-- Choose City/ District --</option>
          @foreach ($city as $city_name)
	    @if($city_name['state_id'] == 1 or $city_name['state_id'] == 2 or $city_name['state_id'] == 3 or $city_name['state_id'] == 4 or $city_name['state_id'] == 5 or $city_name['state_id'] == 6 or $city_name['state_id'] == 7 or $city_name['state_id'] == 8 or $city_name['state_id'] == 9 or $city_name['state_id'] == 10 or $city_name['state_id'] == 11 or $city_name['state_id'] == 12 or $city_name['state_id'] == 13 or $city_name['state_id'] == 14 or $city_name['state_id'] == 15 or $city_name['state_id'] == 16 or $city_name['state_id'] == 17 or $city_name['state_id'] == 18 or $city_name['state_id'] == 19 or $city_name['state_id'] == 20 or $city_name['state_id'] == 21 or $city_name['state_id'] == 22 or $city_name['state_id'] == 23 or $city_name['state_id'] == 24 or $city_name['state_id'] == 25 or $city_name['state_id'] == 26 or $city_name['state_id'] == 27 or $city_name['state_id'] == 28 or $city_name['state_id'] == 29 or $city_name['state_id'] == 30 or $city_name['state_id'] == 31 or $city_name['state_id'] == 32 or $city_name['state_id'] == 33 or $city_name['state_id'] == 34 or $city_name['state_id'] == 35 or $city_name['state_id'] == 36 or $city_name['state_id'] == 37 or $city_name['state_id'] == 38 or $city_name['state_id'] == 39 or $city_name['state_id'] == 40 or $city_name['state_id'] == 41)
                   <option value="{{ $city_name->name }}~~{{ $city_name->state_id }}">{{ $city_name->name }} </option>
    	    @endif
          @endforeach
        </select>

        @error('company_location')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
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
	<select name="company_state" id="company_state" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" title="State">
          <option value="" disabled selected>-- Choose State --</option>
          @foreach ($state as $state_name)
	  @if($state_name['country_id'] == 101)
	          <option value="{{ $state_name->id }}">{{ $state_name->name }} </option>
	  @endif
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

      <!-- Pincode label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for=" Pin Code" style="line-height: 54px; font-weight: bold">
          Pincode*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="company_pincode" id="company_pincode" placeholder="Pincode" maxlength="6" title="Pincode" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="6" minlength="1" pattern="[1-9][0-9]{5}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"/>
        <div id="phone_error1" class="error hidden">Please enter a numeric value only</div>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
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
        <input type="text" name="gst_no" id="gst_no" placeholder="GST Number" title="GST Number" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="15" minlength="1"/>
        <div id="phone_error2" class="error hidden">Please enter valid gst number</div>
        @error('gst_no')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="col-2">
      </div>
    </div>

    <!-- Primary Contact User label and input field -->
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Primary Contact User" style="line-height: 54px;font-weight: bold">
          Primary Contact Name*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="company_contact_user" id="company_contact_user" placeholder="Contact Name (Primary)" title="Primary Contact User" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="50" minlength="1"onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)"/>
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
        <label class="uppercase tracking-wide text-black mb-2" for="Primary Phone" style="line-height: 54px;font-weight: bold">
          Primary Phone*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="company_phone" id="company_phone" placeholder="Phone Number (Primary)" title="Primary Phone" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
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
        <label class="uppercase tracking-wide text-black mb-2" for="Primary Email" style="line-height: 54px; font-weight: bold">
          Primary Email*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="email" name="email" placeholder="Email Address (Primary)" title="Primary Email" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" required maxlength="50" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
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
    <div class="row flex mb-6 mt-2">
      <div class="col-2">
      </div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Contact User" style="line-height: 54px; font-weight: bold">
          Secondary Contact Name
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="contact_person_secondary" id="contact_person_secondary" placeholder="Contact Name (Secondary)" title="Secondary Contact User" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" maxlength="50" minlength="1" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32)" />
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
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Contact Phone" style="line-height: 54px; font-weight: bold">
          Secondary Contact Phone
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="text" name="contact_no_secondary" id="Company_contact_no" placeholder="Contact Phone (Secondary)" title="Secondary Contact Phone" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" maxlength="10"/>
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
        <label class="uppercase tracking-wide text-black mb-2" for="Secondary Email" style="line-height: 54px; font-weight: bold">
          Secondary Email
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="email" name="company_email_secondary" id="company_email_secondary" placeholder="Email Address (Secondary)" title="Secondary Email" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" maxlength="30" minlength="1" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
        @error('')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
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
	<select name="sumbitted_name" id="sumbitted_name" required class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" title="State">
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

    <!-- Form submit button  -->
    <div class="mb-12" style="text-align: center">
      <button type="submit" class="neon-pink-hover md:w-full mt-7 text-white py-2 px-4 rounded-full" style="width: 110px; font-weight:bold; font-size: 1.1rem;">
        Submit
      </button>
    </div>
  </form>

</div>

<!-- Validation for input fields -->
<script>
  function validatePhoneNumber(input_str1) {

    var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;


    return re.test(input_str1);
  }

  function validateForm(event) {
    var phone = document.getElementById('company_phone').value;
    if (!validatePhoneNumber(phone)) {
      document.getElementById('phone_error').classList.remove('hidden');
    } else {
      document.getElementById('phone_error').classList.add('hidden');
      return view(registercilent);
    }
    event.preventDefault();
  }

  document.getElementById('register_cilent_form').addEventListener('submit', validateForm);
</script>

<script>
  function validateGstNumber(input_str2) {

    var re = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/im;


    return re.test(input_str2);
  }

  function validateForm(event) {
    var gst = document.getElementById('gst_no').value;
    if (!validateGstNumber(gst)) {
      document.getElementById('phone_error2').classList.remove('hidden');
    } else {
      document.getElementById('phone_error2').classList.add('hidden');
      return view(registercilent);
    }
    event.preventDefault();
  }

  document.getElementById('register_cilent_form').addEventListener('submit', validateForm);
</script>

<script>
  function validatePinNumber(input_str3) {

    var re = /^\d+/im;

    return re.test(input_str3);
  }

  function validateForm(event) {
    var gst = document.getElementById('company_pincode').value;
    if (!validatePinNumber(gst)) {
      document.getElementById('phone_error1').classList.remove('hidden');
    } else {
      document.getElementById('phone_error1').classList.add('hidden');
      return view(registercilent);
    }
    event.preventDefault();
  }

  document.getElementById('register_cilent_form').addEventListener('submit', validateForm);
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>

// State and city Selected dropdown script
$(document).ready(function(){
 
 // Initialize select2
$("#company_state").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#company_state').click(function(){
     var username = $('#company_state option:selected').text();
 });

 // Initialize select2
$("#company_location").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#company_location').click(function(){
     var username = $('#company_location option:selected').text();
 });

   // Initialize select2
$("#sumbitted_name").select2({
     /* Sort data using lowercase comparison */
     sorter: data => data.sort((a,b) => a.text.toLowerCase() > b.text.toLowerCase() ? 0 : -1)
});

 // Read selected option
 $('#sumbitted_name').click(function(){
     var username = $('#sumbitted_name option:selected').text();
 });

});

$('body').click(function (event)
{
   if(!$(event.target).closest('#success_msg').length && !$(event.target).is('#success_msg')) {
//        $('#success_msg').modal('hide');
   }
});
</script>

<!-- Select city and auto fill state script -->

<script type="text/javascript">
        $(document).ready(function () {
      

            $('#company_location').on('change', function () {
                var stateId = this.value;
                const state_Id = stateId.split("~~");
                
                $('#company_state').html('');
                $.ajax({
                    url: "{{ route('fetch-states') }}",
                    type: "POST",
                    data: {
                      state_id: state_Id[1],
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {

                        $.each(result.states, function (key, value) {
                            $('#company_state').append('<option value="' + value
                                .name + '">' + value.name + '</option>');
                        });
                    }
                    
                });

            });
        });

    </script>

@endsection
