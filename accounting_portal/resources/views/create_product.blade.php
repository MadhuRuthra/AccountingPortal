@extends('layouts.app')
@section('content')

<!-- Container for the Product list -->
<div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 flex flex-col">
		<!-- Heading for this page -->
		<div class="mb-4 text-center text-2xl" style="color:#880009 !important;"> 
				Create Product
		</div>  
		 <!-- This form connected to route('product') in web.php -->
		<form action="{{ route('product') }}" method="POST" name="campaign_form" id="campaign_form" onsubmit="return validateForm()" enctype="multipart/form-data">

				@csrf
				<!-- Product Name label and input field -->
				<div class="row flex mb-6 mt-2">
    <div class="col-3">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
	<label class="uppercase tracking-wide text-black mb-2" for="Product Name" style="line-height: 54px;">
									 Product Name*
								</label>
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
	<input name="product_name" required
										class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="product_name" title="Product Name"
										type="text" placeholder="Product Name" maxlength="100">
      </div>
    <div class="col-3">
    </div>
</div>

 <!-- Product Details label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-3">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
	<label class="uppercase tracking-wide text-black mb-2" for="Product Details" style="line-height: 54px;">
									 Product Details*
								</label>
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
	<input name="product_details" required
										class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="product_details" title="Product Details"
										type="text" placeholder="Product details" maxlength="300">
      </div>
    <div class="col-3">
    </div>
</div>

<!-- Per Piece Rate label and input field -->
<div class="row flex mb-6 mt-2">
    <div class="col-3">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
	<label class="uppercase tracking-wide text-black mb-2" for="Per Piece Rate" style="line-height: 54px;">
    Per Piece Rate*
    </label>
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
	<input name="product_rate" required
                                                                class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="product_rate" title="Per Piece Rate"
                                                                type="text" placeholder="Product Per Piece Rate" maxlength="20">

		<!-- GST Percentage label and input field -->														
      </div>
    <div class="col-3">
    </div>
</div>

<div class="row flex mb-6 mt-2">
    <div class="col-3">
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
	<label class="uppercase tracking-wide text-black mb-2" for="GST Percentage" style="line-height: 54px;">
                                                                         GST Percentage*
                                                                </label>
    </div>
    <div class="col-3 px-3 mb-6 md:mb-0">
<input name="product_gst" required
                                                                class="w-full text-black border border-gray-200 rounded py-3 px-4 mb-3" id="product_gst" title="GST Percentage" min="0" max="99"
                                                                                type="number" placeholder="Product GST %" maxlength="2">
      </div>
    <div class="col-3">
    </div>
</div>








						<div class="		-   mx-3 md:flex mb-6">
						
						<div class="md:w-1/2 px-3">
						</div>
						
				</div>
						<div class="		-   mx-3 md:flex mb-6">
				</div>


				<div class="-   mx-3 md:flex mb-6">
						<div class="md:w-1/2 px-3 mb-4 md:mb-0">
							<!-- Clear Button for Product page -->
								<a href="{{ route('create_product') }}">
										<button type="button" id="clear_btn"
										class=" md:w-full mt-7 bg-gray-900  text-white py-2 px-4 border-b-4 hover:border-b-2 border-gray-500 hover:border-gray-100 rounded-full">
										Clear
								</button></a>
						</div>
						<div class="md:w-1/2 px-3 mb-4 md:mb-0">
							<!-- Submit Button for Product page -->
							<input type="hidden" name='hid_prdqty' id='hid_prdqty' value=''>
							<input type="hidden" name='hid_prdrate' id='hid_prdrate' value=''>
							<input type="hidden" name='hid_prdgstpercentage' id='hid_prdgstpercentage' value=''>
							<input type="hidden" name='hid_prdgstamount' id='hid_prdgstamount' value=''>
							<input type="hidden" name='hid_prdtotalamount' id='hid_prdtotalamount' value=''>

								<button type="submit" name="submit_btn" id="submit_btn"
										class="md:w-full mt-7 bg-gray-900 text-white py-2 px-4 border-b-4 hover:border-b-2 border-gray-500 hover:border-gray-100 rounded-full">
										Submit
								</button>
						</div>
						<div class="md:w-1/2 px-3 mb-4 md:mb-0">
								<a href="{{ route('product') }}">
									<!-- Cancel Button for Product page -->
										<button type="button" id="cancel_btn"
										class=" md:w-full mt-7 bg-gray-900  text-white py-2 px-4 border-b-4 hover:border-b-2 border-gray-500 hover:border-gray-100 rounded-full">
										Cancel
								</button></a>
						</div>
				</div>
</div>


@endsection

