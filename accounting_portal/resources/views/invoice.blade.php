@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')
<style>
.fade:not(.show) { opacity: 0.5; }

.badge{

  background-color:#880009;
  width:250px;
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
.neon-pink-hover {
  background-color:black !important;
  color:white !important;
  border: 1px solid #000 !important;
}
.neon-pink-hover:hover{

  background-color:#f6d8d8 !important;
  color:black !important;
}
.searchbtn{
    border-radius:25px;
    background-color:black;
    color:white;
    font-weight:bold;
    border: 1px solid #000 !important;
}
.searchbtn:hover{
    background-color:#f6d8d8;
    color:black;
    font-weight:bold;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div style="background-color: #FFF;border-top-left-radius: 0.5rem;border-top-right-radius: 0.5rem;padding: 20px 0 15px 20px;text-align: center;">
    <!-- Heading for this page -->
        <h2 class="text-2xl font-medium" style="font-weight:bold; color:white;"><span class="badge" style="">GST Status</h2>
    </div>

    <div  style = "display: flex; justify-content:flex-left" >         

    </div>
    <!-- Card Body -->
    <div class="card mt-2">
        <div class="card-header">

        <!-- Fromdate to Todate filter with validation  -->
		<div class="row mt-2">
    
                    <div class="col col-sm-12 col-md-2" style="text-align: right; line-height: 40px;">
                        <label><strong>From Date :</strong></label>
                    </div>
                    <div class="col  col-md-3">
                        <input type="date" name="detail_from_date" id="detail_from_date" class="form-control" style="width:100%" max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixtodate()" value="{{ Carbon\Carbon::now()->format('Y-m') }}-01">
                    </div>
                    <div class="col  col-md-2" style="text-align: right; line-height: 40px;">
                        <label><strong>To Date :</strong></label>
                    </div>
                    <div class="col  col-md-3">
                        <input type="date" name="detail_to_date" id="detail_to_date" class="form-control" style="width:100%" max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixfrmdate()" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="col  col-md-2">
                        <div class="flex">
                            <button type="submit" class=" btn mx-2 font-bold searchbtn" id="detail_get_filter" style="width:100%;">Search</button>
                        </div>
                        </from>
                    </div>
                </div>

        </div>
        <!-- Datatable columns name -->
        <div class="col card-body table-responsive">
            <table class="invoice_data-table hover stripe" id="invoice_data-table"   style="width:100%">
                <thead>
                    <tr>
                    <th>S.No</th>
                    <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Particulars</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Sub Total Amount</th>
                        <th>GST Amount</th>
                        <th>Total Amount</th>
			<th>GST Number</th>
                        <th class="noExport">Downloads</th>
                     <!--   <th class="noExport">{{ Auth::user()->user_master_id}}</th> -->
                        @if(Auth::user()->user_master_id == 3)
                        <th>GST Status</th>
                        @endif
                        <th class="noExport">GST File Details</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

  <!-- Modal popup for po details -->
<div class="modal" tabindex="-1" role="dialog" id="default-Modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form name="frm_po_details" id='frm_po_details' action="{{ route('invoice') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">PO Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        Enter PO Details : <input type="text" name="txt_po_details" id="txt_po_details" class="form-control" value="" maxlength="10" tabindex="1" autofocus="" required="" data-toggle="tooltip" data-placement="top" title="" data-original-title="PO Details" placeholder="PO Details">
      </div>
      <div class="modal-footer">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="hid_accounting_invoice_id" id="hid_accounting_invoice_id" class="form-control" value="">
        <button type="submit" name='sbmt_po' id='sbmt_po' value="sbmt_po" class="btn btn-danger" style="border: 1px solid #000 !important;">Submit</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal" style="border: 1px solid #000 !important;">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal popup for Payment details -->
<div class="modal" tabindex="-1" role="dialog" id="default-Modal1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form name="frm_pay_details" id='frm_pay_details' action="{{ route('payment') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        PO Received : <input type="radio" name="rdo_po_received" id="rdo_po_received" tabindex="1" autofocus value="Y" checked="checked"> Yes <input type="radio" name="rdo_po_received" id="rdo_po_received" tabindex="2" value="N"> NO
      </div>
      <div class="modal-footer">
      <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="hidd_accounting_invoice_id" id="hidd_accounting_invoice_id" class="form-control" value="">
	      <button type="submit" name='sbmt_payment' id='sbmt_payment' value="sbmt_payment" class="btn btn-danger" style="border: 1px solid #000 !important;">Submit</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal" style="border: 1px solid #000 !important;">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal popup for Filing status -->
<div class="modal" tabindex="-1" role="dialog" id="default-Modal2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form name="frm_file_details" id='frm_file_details' action="{{ route('filing') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Filing Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        Filing Status : <input type="radio" name="rdo_file_received" id="rdo_file_received" tabindex="1" autofocus value="Y" checked="checked"> Filed <input type="radio" name="rdo_file_received" id="rdo_file_received" tabindex="2" value="N"> Not Filed
      </div>
      <div class="modal-footer">
      <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="hiddd_accounting_invoice_id" id="hiddd_accounting_invoice_id" class="form-control" value="">
	      <button type="submit" name='sbmt_filing' id='sbmt_filingt' value="sbmt_filing" class="btn btn-danger" style="border: 1px solid #000 !important;">Submit</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal" style="border: 1px solid #000 !important;">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal popup for filing upload -->
<div class="modal" tabindex="-1" role="dialog" id="default-Modal3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form name="file_upload_detail" id='file_upload_detail' action="{{ route('filing-upload') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-header">
	<h2 class="text-2xl font-medium" style="font-weight:bold; color:white; width: 100%;"><span class="badge" style="width: 100%;">GST File Upload</span></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">

        Upload GST File (Pdf, Jpg, Png) : <input type="file" accept="image/jpg, image/jpeg, image/png, application/pdf" name="filing_upload[]" id="filing_upload" class="form-control" value="" enctype="multipart/form-data" maxlength="10" tabindex="1" autofocus="" required="" data-toggle="tooltip" data-placement="top" title="" data-original-title="PO Details" placeholder="">

      </div>
      <div class="modal-footer">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="hidddd_accounting_invoice_id" id="hidddd_accounting_invoice_id" class="form-control" value="">
        <button type="submit" name='sbmt_po' id='sbmt_po' value="sbmt_po" class="neon-pink-hover btn btn-default" style="border-radius:25px; border:1px solid #000 !important;">Submit</button>
        <button type="button" class="neon-pink-hover btn btn-default" data-dismiss="modal" style="border-radius:25px; border:1px solid #000 !important;">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-md" id="success_msg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="width: 615px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -35%); overflow: visible; opacity: 1">
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

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- Modal popup scripts -->
<script>
function call_podet(accno) {
	$("#hid_accounting_invoice_id").val(accno);
	$('#default-Modal').modal({ show: true });
}

function call_paydet(accno) {
        $("#hidd_accounting_invoice_id").val(accno);
        $('#default-Modal1').modal({ show: true });
}
function call_filing(accno) {
        $("#hiddd_accounting_invoice_id").val(accno);
        $('#default-Modal2').modal({ show: true });
}
function filing_upload(accno) {
        $("#hidddd_accounting_invoice_id").val(accno);
        $('#default-Modal3').modal({ show: true });
}

function func_fixtodate() {
        var frmdate = $("#detail_from_date").val();
        $('#detail_to_date').attr('min', frmdate);
}

function func_fixfrmdate() {
        var todate = $("#detail_to_date").val();
        $('#detail_from_date').attr('max', todate);
}

$('body').click(function (event) 
{
   if(!$(event.target).closest('#success_msg').length && !$(event.target).is('#success_msg')) {
	$('#success_msg').modal('hide');
   }     
});
</script>

@endsection
