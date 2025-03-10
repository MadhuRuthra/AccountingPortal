@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')
               
    <div class="mt-4 px-3 ">
        <!-- Heading for this page -->
        <h2 class="text-2xl font-medium" style="font-weight:bold">Product List</h2>
    </div>
    <!-- Create product page buton -->
    <div style="float: right;width: 100%;padding-bottom: 10px;text-align: right;" >         
         <input type="button"  onclick="window.location='{{ url("create_product") }}'" class="btn btn-success mx-2 font-bold" id="get_create_product" value="[+] Add Product"> 
         <!-- Card body -->
     </div>
    <div class="card mt-2">
        <div class="card-header" style="display: none;">
            <!-- Fromdate to Todate filter with validation  -->
                <div class="row mt-2">
                    <div class="col col-sm-12 col-md-3">
                        <label><strong>Filter :</strong></label>

                    <input type="text" name="detail_search" id="detail_search" class="form-control" style="width:100%" value="">
                   
                    </div>
                    <div class="col  col-md-3">
                        <label><strong>From Date :</strong></label>
                        <input type="date" name="detail_from_date" id="detail_from_date" class="form-control" style="width:100%" value="{{ Carbon\Carbon::now()->format('Y-m-d')}}">
                    </div>
                    <div class="col  col-md-3">
                        <label><strong>To Date :</strong></label>
			<input type="date" name="detail_to_date" id="detail_to_date" class="form-control" style="width:100%" value="{{ Carbon\Carbon::now()->format('Y-m-d')}}">
                    </div>
                    <div class="col  col-md-3">
			    <div style="height: 30px;">&nbsp;</div>
                            <button type="submit" class=" btn btn-primary mx-2 font-bold" id="detail_get_filter" style="width:100%">Search</button>
                    </div>
                </div>
        </div>
        <!-- Datatable columns names -->
        <div class="col card-body table-responsive">
            <table class="product_data-table hover stripe" id="product_data-table"   style="width:100%">
                <thead>
                    <tr>
                    <th>S.No</th>
                        
                        <th>Product Name</th>
                        <th>Product Details</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>GST Percentage</th>
                        <th>Product Status</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

<div class="modal fade bs-example-modal-md" id="success_msg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px;">
  <div class="modal-dialog modal-md">
    <div class="modal-content" style="width: 600px; min-height: 400px; border-radius: 5px;">
        <div>
            <!-- Close button content -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 40px; padding: 0px;border-radius: 5px;">
        <span aria-hidden="true">x</span>
        </button>
        </div>

        <div id="mdl">
        <p>Hello</p>
        </div>
    </div>
  </div>
</div>
<script>
$('body').click(function (event)
{
   if(!$(event.target).closest('#success_msg').length && !$(event.target).is('#success_msg')) {
        $('#success_msg').modal('hide');
   }
});
</script>
@endsection
