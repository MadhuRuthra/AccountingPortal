@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')

<style>
.fade:not(.show) { opacity: 0.5; }
.bg-red-200 { background-repeat: repeat; background-size: cover; }

.badge{
  background-color:#880009;
  width:290px;
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

.modal-backdrop { opacity: 1 !important; }

/* Add glow effect on hover */
.neon-pink-hover {
  background-color:black !important;
  color:white !important;
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

<!-- Heading for this page -->
<div style="background-color: #FFF;border-top-left-radius: 0.5rem;border-top-right-radius: 0.5rem;padding: 20px 0 15px 20px;text-align: center;"><h2 class="text-2xl font-medium" style="font-weight:bold; color:white;"><span class="badge" style="">Summary List</h2></div>
                <!-- Card Body -->
    <div class="card mt-2" style="z-index: 10; width: 100%; /* 1590px; */ min-height: 700px;">
        <div class="card-header">

        <!-- Fromdate to Todate filter with validation  -->
		<div class="row mt-2" style="width: 100%;">
                    <div class="col col-sm-12 col-md-2" style="text-align: right; line-height: 40px;">                 
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
         <!-- Datatable columns name -->
        <div class="col card-body table-responsive">
            <table class="summary_data-table row-border hover stripe" id="summary_data-table"   style="width:100%; text-align: center;">
                <thead>
                    <tr style="text-transform: capitalize !important;">
                        <th>S.No</th>
                        <th>Month</th>
                        <th>Quotation No</th>
                        <th>Quotation Date</th>
                        <th>Quotation Submitted By</th>
                        <th>PO Details</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Invoice Submitted By</th>
                        <th>Company Name</th>
                        <th style="text-transform: capitalize !important;">Location</th>
                        <th>Contact Person</th>
                        <th>Particulars</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Sub Total</th>
                        <th>GST Amount</th>
                        <th>Total Amount</th>
                        <th>Campaign Date</th>
                        <th>Submitted Date</th>
		        <th class="noExport">Downloads</th>
                        <th>GST Status</th>
                        <th>Payment Status</th>
                        <!-- <th>Received Date</th>
                        <th>Payment Mode</th>
                        <th>Remarks</th>
                        <th class="noExport">Payment Attachment</th> -->
	                <th class="noExport">Generate Invoice</th>                      
		        <th class="noExport">Payment</th>
			<th class="noExport">Action</th>
                        
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

      <form name="frm_po_details" id='frm_po_details' action="" method="post">
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
        <input type="hidden" name="hid_accounting_invoice_id" id="hid_accounting_invoice_id" class="form-control" value="">
        <button type="button" name='sbmt_po' id='sbmt_po' class="btn btn-danger">Submit</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal popup for Payment Details -->
<div class="modal" tabindex="-1" role="dialog" id="default-Modal1_view">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content" style="height: 700px;">

      <form name="frm_pay_details" id='frm_pay_details' action="{{ route('summary_payment') }}" method="POST" enctype="multipart/form-data">
        @csrf
	<div class="modal-header">
          <h2 class="text-2xl font-medium" style="font-weight:bold; color:white; width: 100%;"><span class="badge" style="width: 100%;">Payment Details</span></h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>

        <div class="modal-body">
        <table style="width: 100%">
        <tr><td style="vertical-align: top; width: 33%"><label style="font-weight:bold;"> Payment Status : </label></td><td id="id_view_payment_status"></tr>

        <tr><td>&nbsp;</td></tr>
        <tr><td style="vertical-align: top;"><label style="font-weight:bold;"> Payment Date : </label></td><td id="id_view_paydate"></tr>
        <tr><td>&nbsp;</td></tr>

        <tr><td style="vertical-align: top;">
        <label style="font-weight:bold;"> Payment Method : </label></td><td id="id_view_paymethod"></tr>

        <tr><td>&nbsp;</td></tr>
        <tr><td style="vertical-align: top;"><label style="font-weight:bold; "> Remarks : </label></td><td id="id_view_remarks"></tr>

        <tr><td>&nbsp;</td></tr>
        <tr><td style="vertical-align: top;"><label style="font-weight:bold; "> Payment Attachment: </label></td><td><div id="id_pay_attach"></div></td></tr>
        </table>

        </div>
        <div class="modal-footer">
          <input type="hidden" id="_token" value="{{ csrf_token() }}">
        </div>
      </form>
    </div>
  </div>
</div>

 <!-- Modal popup for Payment Details -->
<div class="modal" tabindex="-1" role="dialog" id="default-Modal1">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content" style="height: 700px;">

      <form name="frm_pay_details" id='frm_pay_details' action="{{ route('summary_payment') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
	  <h2 class="text-2xl font-medium" style="font-weight:bold; color:white; width: 100%;"><span class="badge" style="width: 100%;">Payment Details</span></h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>

        <div class="modal-body">
<table style="width: 100%">
  <tr><td style="vertical-align: top; width: 33%">
       <label style="font-weight:bold;"> Payment Status : </label></td><td><input type="radio" name="rdo_po_received" id="rdo_po_received" tabindex="1" autofocus value="Y" checked="checked"> Received<br>
	<input type="radio" name="rdo_po_received" id="rdo_po_receivedn" value="N"> Not Received</tr>
      
<tr><td>&nbsp;</td></tr>

<tr><td style="vertical-align: top;">
       <label style="font-weight:bold;"> Payment Date : </label></td><td><input type="datetime-local" name="paymentdate" id="paymentdate" class="form-control" style="width:100%" max="{{ Carbon\Carbon::now()->format('Y-m-d')}}"></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="vertical-align: top;">
        <label style="font-weight:bold;"> Payment Method : </label></td><td>
        <input type="radio" name="rdo_po_method" id="rdo_po_method" tabindex="1" autofocus value="Q" checked="checked"> Cheque <br><input type="radio" name="rdo_po_method" id="rdo_po_method" tabindex="2" value="C"> Cash <br><input type="radio" name="rdo_po_method" id="rdo_po_method" tabindex="3" value="O"> Online Payment (Card/Netbanking/UPI)<br><input type="radio" name="rdo_po_method" id="rdo_po_method" tabindex="4" value="N"> Not Paid </td></tr>

<tr><td>&nbsp;</td></tr>
        <tr><td style="vertical-align: top;"><label style="font-weight:bold; "> Remarks : </label></td>
        <td><textarea name="rdo_po_remark" id="rdo_po_remark" rows= "4" cols = "25" maxlength="250" placeholder=" Enter your remarks here, [250 Characters allowed]" style="border: 1px solid black; border-radius:6px; background-color:#F5F5F5; padding: 10px; width: 100%;" required></textarea></td></tr>
  
      
   <tr><td>&nbsp;</td></tr>
        <tr><td style="vertical-align: top;"><label style="font-weight:bold; "> Payment Attachment: </label></td>
        <td><input type="file" class="form-control" style="width:100%" id="payment_attachment"  name="payment_attachment[]" accept=".pdf,.png,.jpg" title="Upload Pdf / Jpg file"><div id="id_pay_attach"></div></td></tr>
     
        </table> 

        </div>
        <div class="modal-footer">
          <input type="hidden" id="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="hidd_accounting_invoice_id" id="hidd_accounting_invoice_id" class="form-control" value="">
          <button type="submit" name='sbmt_payment' id='sbmt_payment' value="sbmt_payment" class="neon-pink-hover btn btn-dark" style="border-radius:25px; border:1px solid #000 !important;">Submit</button>
          <button type="button" class="neon-pink-hover btn btn-dark" data-dismiss="modal" style="border-radius:25px; border:1px solid #000 !important;">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade bs-example-modal-md" id="success_msg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="width: 615px; position: relative; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; opacity: 1">
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

function myFunction(invoice_id) {
  if (confirm("“Do you want to delete, instead you can edit the activity”")) {
    func_quotdel(invoice_id) 
  } else {
   
  }
}

function func_quotdel(invoice_id) {

    $.ajax({
	url: 'quotation_del',
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "invoice_id": invoice_id
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

function call_podet(accno) {
	$("#hid_accounting_invoice_id").val(accno);
	$('#default-Modal').modal({ show: true });
}

function call_view_paydet(accno, payment_method, remarks, payment_received, payment_date,payment_attachment) {
        $("#hidd_accounting_invoice_id").val(accno);
        if(payment_attachment != ''){
          $("#id_pay_attach").html('<a href="public/uploads/'+payment_attachment+'" download class="btn btn-xs btn-success" title="Download Attachment"><svg xmlns="http://www.w3.org/2000/svg"height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc.--><style>svg{fill:#ffffff}</style><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.512.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg></a>');
        }
        $('#id_view_paydate').html(payment_date);
        if(payment_method == 'Q')
                $("#id_view_paymethod").html("Cheque");
        else if(payment_method == 'C')
                $("#id_view_paymethod").html("Cash");
        else if(payment_method == 'O')
                $("#id_view_paymethod").html("Online Payment (Card/Netbanking/UPI)");
        else if(payment_method == 'N')
                $("#id_view_paymethod").html("Not Paid");

        $('#id_view_remarks').html(remarks);

        if(payment_received == 'Y') {
                $("#id_view_payment_status").html("Received");
        } else {
                $("#id_view_payment_status").html("Not Received");
        }
        $('#default-Modal1_view').modal({ show: true });
}

//submited values display in edit payment modal popup
function call_paydet(accno, payment_method, remarks, payment_received, payment_date,payment_attachment) {
        $("#hidd_accounting_invoice_id").val(accno);
        if(payment_attachment != ''){
          $("#id_pay_attach").html(payment_attachment);
        }
	$('#paymentdate').val(payment_date);
	if(payment_method != '')
		$("input[name=rdo_po_method][value=" + payment_method + "]").prop('checked', true);

	$('#rdo_po_remark').val(remarks);
	$("input[name=rdo_po_received][value='N']").prop('checked', true);

	if(payment_received == 'Y') {
		$("input[name=rdo_po_received][value='Y']").prop('checked', true);
	} else {
                
	}
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
// Date filter Validation
function func_fixtodate() {
        var frmdate = $("#detail_from_date").val();
        $('#detail_to_date').attr('min', frmdate);
}

function func_fixfrmdate() {
        var todate = $("#detail_to_date").val();
        $('#detail_from_date').attr('max', todate);
}

/* $('body').click(function (event)
{
   alert("##");
   if(!$(event.target).closest('#success_msg').length && !$(event.target).is('#success_msg')) {
        $('#success_msg').modal('hide');
   }
}); */
</script>

@endsection
