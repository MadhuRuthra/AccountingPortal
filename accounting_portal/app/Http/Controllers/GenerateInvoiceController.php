<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Accounting_invoice;
use DB;
use Illuminate\Support\Facades\Auth;

class GenerateInvoiceController extends Controller
{
  public function generateInvoice($quotation_no)
  {
    if (Auth::id() == '') {
      return redirect()->route('login');
    }
    // Admin and sales team only access this pages 
    if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
      return redirect()->route('home');
    }
    // accounting_invoice table data
    $invoice_data = DB::table('accounting_invoices')
      ->where('accounting_invoice_id', $quotation_no)
      ->get();


    $company_id = $invoice_data->pluck('company_id');

    // company_masters table data
    $company_data = DB::table('company_masters')
      ->whereIn('user_id', $company_id)
      ->get();

    // Get data from database using queries
    $product_data = DB::table('accounting_invoices AS acc_inv')
      ->select('pro_mas.product_master_name', 'acc_inv_pro.*')
      ->join('accounting_invoice_products AS acc_inv_pro', 'acc_inv.accounting_invoice_id', '=', 'acc_inv_pro.accounting_invoice_id')
      ->join('product_masters AS pro_mas', 'acc_inv_pro.product_master_id', '=', 'pro_mas.product_master_id')
      ->where('acc_inv.accounting_invoice_id', $quotation_no)
      ->get();
	
    $contact_p = DB::table('accounting_invoice_contact as ac')
      ->select('ac.contact_name', 'ac.contact_mobile', 'ac.contact_email','ac.acc_inv_contact_id')
      ->join('accounting_invoices as ai', 'ac.accounting_invoice_id', '=', 'ai.accounting_invoice_id')
      ->where('ac.contact_type', '=', 'P')
      ->where('ac.accounting_invoice_id', '=', $quotation_no)
      ->get();
  
    $contact_s = DB::table('accounting_invoice_contact as ac')
      ->select('ac.contact_name', 'ac.contact_mobile', 'ac.contact_email','ac.acc_inv_contact_id')
      ->join('accounting_invoices as ai', 'ac.accounting_invoice_id', '=', 'ai.accounting_invoice_id')
      ->where('ac.contact_type', '=', 'S')
      ->where('ac.accounting_invoice_id', '=', $quotation_no)
      ->get();

    $response = [ // Get tables datas and stored in array
      'company_data' => $company_data,
      'product_data' => $product_data,
      'invoice_data' => $invoice_data,
      'contact_data' => $contact_p,
      'contact_data2' => $contact_s,
    ];

    return response()->json($response);

  }

  public function generatingInvoice() // Values get function for Generate_invoice
  {
    // Get id, quotation_sr_no in array from Accounting_invoice Model file
    $company_name_value = Accounting_invoice::select('accounting_invoice_id', 'entry_status', 'quotation_sr_no')->where('invoice_sr_no')->get()->toArray();

    return view('generate_invoice', ['company_name_value' => $company_name_value]);
  }


  public function invoiceform(Request $request) // Generate invoice form function
  {

    if (Auth::id() == '') {
      return redirect()->route('login');
    }
    // Admin and Sales team only access this page
    if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
      return redirect()->route('home');
    }

    // Get input data from input fileds
    $quota_no1 = $request->input('quota_no1');
    $purchase_order_no = $request->input('purchase_order_no');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $po_attachment = $request->input('po_attachment');
    $invoice_submitted_name = $request->input('quota_submitted_name');
    $quota_remarks = $request->input('quota_remarks');
    $quota_remarks_2 = $request->input('quota_remarks_2');
    $quota_bank_name = $request->input('quota_bank_name');


	$date = now();
	
	if (date_format($date,"m") >= 4) {//On or After April (FY is current year - next year)
        $quot = "/" .(date_format($date,"y")) . '-' . (date_format($date,"y")+1);
	} else {//On or Before March (FY is previous year - current year)
        $quot = "/" .(date_format($date,"y")-1) . '-' . date_format($date,"y");
	}

//    $quot = "/" . date("y") . "-" . date("y", strtotime('+1 year'));
    $mxaccidValue = '';
    if($request->input('quota_no1') < 10) {
        $mxaccidValue = '00';
    } elseif($request->input('quota_no1') >=10 and $request->input('quota_no1') <   100) {
        $mxaccidValue = '0';
    } elseif($request->input('quota_no1') >= 100) {
        $mxaccidValue = '';
    }

    // Create Invoice serial number using id value
    $invoice_sr_no = "CM" . $mxaccidValue . $request->input('quota_no1') . $quot;

    $fileName = '';

    if ($request->file()) { // Get file value in condition 

      $files = $request->file('po_attachment');
      // The given file name modified with current time and "_payment_" unic name
      $fileName = time() . '_' . 'quotation' . '_' . $files->getClientOriginalName();
      // The modified file name stored in Public path
      $files->move(public_path('uploads'), $fileName);

    }

    $submit_date = date("Y-m-d H:i:s");

     // Get all values in array and insert the values in DB Table
    $file1_upload = array('po_details' => $purchase_order_no, 'po_attachment' => $fileName, 'start_date' => $start_date, 'end_date' => $end_date, 'received_date' => $submit_date, 'invoice_sr_no' => $invoice_sr_no,'invoice_submitted_by' => $invoice_submitted_name, 'quotation_remarks' => $quota_remarks, 'quotation_remarks_2' => $quota_remarks_2, 'bank_master_id' => $quota_bank_name);

    $update = DB::table('accounting_invoices')
      ->where('accounting_invoice_id', $quota_no1)
      ->update($file1_upload); // Update values in DB table

    Session::flash('invoice_pdf', 'invoice_pdf/' . $quota_no1);
    return Redirect::to('generate_invoice')->with('success', 'Invoice Generated Successfully'); //Return redirect with success message from Generate Invoice page

  }

}
