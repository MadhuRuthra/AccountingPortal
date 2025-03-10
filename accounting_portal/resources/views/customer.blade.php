@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')
               
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
.searchbtn{
    border-radius:50px;
    background-color:black;
    color:white;
    font-weight:bold;
    border: 1px solid #000;
}
.searchbtn:hover{
    background-color:#f6d8d8;
    color:black;
    font-weight:bold;
    border: 1px	solid #000;
}
</style>
    <!-- Heading For this page -->
    <div style="background-color: #FFF;border-top-left-radius: 0.5rem;border-top-right-radius: 0.5rem;padding: 20px 0 15px 20px;text-align: center;">
        <h2 class="text-2xl font-medium" style="font-weight:bold; color:white;"><span class="badge" style="">Existing Clients</h2>
    </div>
    <!-- Card Body  -->
    <div class="card">
        <div class="card-header">
            
                <div class="row mt-2">
                    <div class="col col-sm-12 col-md-2" style="text-align: right; line-height: 40px;">
                <!-- From and To date Filter  -->
			<label><strong>From Date :</strong></label>
                    </div>
                    <div class="col  col-md-3">
                        <input type="date" name="detail_from_date" id="detail_from_date" class="form-control" style="width:100%" max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixtodate()">
                    </div>
                    <div class="col  col-md-2" style="text-align: right; line-height: 40px;">
                        <label><strong>To Date :</strong></label>
		    </div>
                    <div class="col  col-md-3">
			<input type="date" name="detail_to_date" id="detail_to_date" class="form-control" style="width:100%" max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixfrmdate()">
                    </div>
                    <div class="col  col-md-2">
                        <div class="flex">
                            <button type="submit" class=" btn mx-2 font-bold searchbtn" id="detail_get_filter" style="width:100%;">Search</button>
                        </div>
                        </from>
                    </div>
                </div>
            
        </div>
        <!-- Datatable and table column names -->
        <div class="col card-body table-responsive">
            <table class="customer_data-table hover stripe" id="customer_data-table"   style="width:100%">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th style="text-transform: capitalize">Client Name</th>
                        <th style="text-transform: capitalize">Client Address</th>
			<th style="text-transform: capitalize">GST NO</th>
			<th style="text-transform: capitalize">Contact Name</th>			
            		<th>Email ID</th>
			<th>Contact No</th>
                        <th>Submitted By</th>
                	<th>Entry Date</th>
			<!-- <th class="noExport">Generate Quotation</th> -->
                	<th class="noExport">Action</th>            
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
<!-- Close button X content -->
<div class="modal fade bs-example-modal-md" id="success_msg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="position: absolute; left: 45.5%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px;">
  <div class="modal-dialog modal-md">
    <div class="modal-content" style="width: 600px; min-height: 400px; border-radius: 5px;">
	<div>
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

<!-- Fromdate to Todate Validation -->
<script>
function func_fixtodate() {
	var frmdate = $("#detail_from_date").val();
	$('#detail_to_date').attr('min', frmdate);
}

function func_fixfrmdate() {
        var todate = $("#detail_to_date").val();
        $('#detail_from_date').attr('max', todate);
}

</script>

<!-- Register client delete action script -->
<script>

function myFunction(userId) {
  if (confirm("“Do you want to delete, instead you can edit the activity”")) {
    func_cusdel(userId) 
  } else {
    
  }
}

function func_cusdel(userId) {
    
    $.ajax({
        url: 'customer_del',
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "user_id": userId
        },
        success: function(response) {
            // Handle the success response here
            console.log(response);
            // Reload the customer view or perform any other necessary actions
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle the error response here
            console.error(error);
        }
    });
}

$('body').click(function (event)
{
   if(!$(event.target).closest('#success_msg').length && !$(event.target).is('#success_msg')) {
        $('#success_msg').modal('hide');
   }
});
</script>


@endsection

