@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')

<style>
  table {
    width: 100%;
    height: 325px;
    border-radius: 5px;
    border-collapse: collapse;
  }

  table tr:nth-child(odd) {
    background-color: #f2f2f2;
  }

  table tr:nth-child(even) {
    background-color: #fff;
  }

  table td {
    padding: 10px;
  }
.modal-dialog {
    max-width: 80%;
    margin: 1.75rem auto;
}

.modal-dialog1{

  max-width: 30%;
    margin: 1.95rem auto;

}

.badge{

  background-color:#880009;
  width:420px;
  height:50px;
  border-radius:22px;
  display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 95%;
    font-weight: 700;
    line-height:40px;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    margin-right:500px;

}
</style>

<div class="mx-auto w-full">
  <div>
    <!-- Card stats -->
    <div class="flex flex-wrap -mx-4">

    <!-- Dashboard pop up modal content -->
    <div class="modal fade bs-example-modal-lg" id="success_msg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: block; position: absolute; left: 0%; top: 0%; transform: translate(0%, 0%); overflow: visible; width: 100%; display: none;">
  <div class="modal-dialog modal-lg" style="overflow: hidden;">

    <div class="modal-content" id='mdl' style="overflow: auto;">
	      <!-- Close button style content -->
        <div style="text-align: right"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align: right; padding-right:3px;" >
        <span aria-hidden="true">x</span>
        </button>
<!-- Heading for this page -->
<h2 class="text-2xl font-medium" style="font-weight:28px; color:white;"><span class="badge" style="">OUTSTANDING PAYMENT</h2><br>

</div>
    <!-- Datatable column names -->
		<table class="invoice_data-table hover stripe" id="home_data-table"   style="width:100%">
                <thead>
                    <tr>
                    <th>S.No</th>
                    <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Particulars</th>
			<th>GST Number</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Sub Total Amount</th>
                        <th>GST Amount</th>
                        <th>Total Amount</th>
		        <th>Payment Status</th>                        
                    </tr>
                </thead>
                <tbody>
                </tbody>
            	</table>

        <br>
    </div>
  </div>
</div>
      
    </div>
  </div>
  <div class="card" style="margin-top:30px; display: none;">
    <div class="card-header" style="background-color:#fff">
      <div style="height:500px;width:900px;margin:auto;background-color:#fff">
        <canvas id="barChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Gst file upload content -->
  <div class="modal" tabindex="-1" role="dialog" id="default-Modal6">
  <div class="modal-dialog1" role="document">
    <div class="modal-content">

      <form name="file_upload_detail" id='file_upload_detail' action="{{ route('filing-upload_1') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">GST File Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Input fields -->
        Upload GST File (Pdf, Jpg, Png) : <input type="file" accept="image/jpg, image/jpeg, image/png, application/pdf" name="filing_upload[]" id="filing_upload" class="form-control" value="" enctype="multipart/form-data" maxlength="10" tabindex="1" autofocus="" required="" data-toggle="tooltip" data-placement="top" title="" data-original-title="PO Details" placeholder="">

      </div>
      <div class="modal-footer">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="hidddd_accounting_invoice_id" id="hidddd_accounting_invoice_id" class="form-control" value="">
        <button type="submit" name='sbmt_po' id='sbmt_po' value="sbmt_po" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
/* $('body').click(function (event)
{
   if(!$(event.target).closest('#success_msg').length && !$(event.target).is('#success_msg')) {
        $('#success_msg').modal('hide');
   }
}); */
</script>

<!-- Model pop up Script -->
<script>
function filing_upload(accno) {
        $("#hidddd_accounting_invoice_id").val(accno);
        $('#default-Modal6').modal({ show: true });
}

</script>
@endsection
