@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')

<style>
input[type=password] { border-radius: 50px !important; }
.badge {
    background-color: #880009;
    width: 380px;
    height: 50px;
    border-radius: 22px;
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 95%;
    font-weight: 700;
    line-height: 40px;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    color: white;
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

         <!-- Change Password container creation -->
        <div class="bg-white w-full rounded-lg shadow overflow-hidden mx-auto">
            <div class="py-4 px-6">
         <!-- Heading for this Container -->
		<div style="background-color: #FFF;border-top-left-radius: 0.5rem;border-top-right-radius: 0.5rem;padding: 20px 0 15px 20px;text-align: center;"><h2 class="text-2xl font-medium" style="font-weight:bold color:white;"><span class="badge" style="">Change Password</span></h2></div>
             <!-- This form connected to route('changepassword') in web.php -->   
            <form class="form" id="change-form" action="{{ route('changepassword') }}" method="post">
                @csrf
<!-- Old Password label and input filed -->
<div class="row flex mb-6 mt-2">
	<div class="col-2"></div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="current_password" style="line-height: 54px; font-weight: bold">
          Old Password*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="password" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" id="current_password" name="current_password" placeholder="Old Password" title="Old Password" maxlength="15">
        @error('current_password')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
	<div class="col-2"></div>
    </div>

<!-- new Password label and input filed -->
<div class="row flex mb-6 mt-2">
        <div class="col-2"></div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="new_password" style="line-height: 54px; font-weight: bold">
          New Password*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="password" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" id="new_password" name="new_password" placeholder="New Password" title="New Password" maxlength="15">
        @error('new_password')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
	@enderror
      </div>
	<div class="col-2"></div>
    </div>

 <!-- Confirm New Password label and input filed -->
<div class="row flex mb-6 mt-2">
	<div class="col-2"></div>
      <div class="col-3 px-3 mb-6 md:mb-0">
        <label class="uppercase tracking-wide text-black mb-2" for="new_password_confirmation" style="line-height: 54px; font-weight: bold">
          Confirm New Password*
        </label>
      </div>
      <div class="col-5 px-3 mb-6 md:mb-0">
        <input type="password" class="w-full mt-2 py-3 px-4 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm New Password" title="Confirm New Password" maxlength="15">
        @error('new_password_confirmation')
        <p class="text-red-500 text-xs italic mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
	<div class="col-2"></div>
    </div>
                 <!-- success and error msg using sessions -->
                @if($errors->any())
            {!! implode('', $errors->all('<div style="color:red">:message</div>')) !!}
            @endif
            @if(Session::get('error') && Session::get('error') != null)
            <div style="color:red">{{ Session::get('error') }}</div>
            @php
            Session::put('error', null)
            @endphp
            @endif
            @if(Session::get('success') && Session::get('success') != null)
            <div style="color:green">{{ Session::get('success') }}</div>
            @php
            Session::put('success', null)
            @endphp
            @endif

        <!-- Submit Button for this container -->
    <div class="mb-12" style="text-align: center">
      <button type="submit" class="neon-pink-hover md:w-full mt-7 text-white py-2 px-4 rounded-full btn btn-dark" style="width: 110px; border:none;">
        Submit
      </button>
    </div>

            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
   
@endsection
