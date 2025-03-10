<?php
namespace App\Http\Controllers;

use App\Models\Accounting_invoice;
use App\Models\Product_master;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;
use App\Models\Company_master;
use App\Models\Master_cities;
use DB;

set_time_limit(0);

class Create_invoiceController extends Controller
{
    //create import  
    public function fileImportExport()
    {
        return view('file-import');
    }

    public function fileImport(Request $request) // Create Quotation page submit function
    {
	$mxaccidValue = 1;

	$date = now();

        if (date_format($date,"m") >= 4) {//On or After April (FY is current year - next year)
        $quot = "/" .(date_format($date,"y")) . '-' . (date_format($date,"y")+1);
	$quot1 = (date_format($date,"y")) . '-' . (date_format($date,"y")+1);
        } else {//On or Before March (FY is previous year - current year)
        $quot = "/" .(date_format($date,"y")-1) . '-' . date_format($date,"y");
	$quot1 = (date_format($date,"y")-1) . '-' . date_format($date,"y");
        }

        $mxaccid = DB::select('SELECT (MAX(accounting_invoice_id) + 1) AS mxaccid FROM accounting_invoices'); // Get the ID Value form database


    //	$mxaccid = DB::select("SELECT (MAX(accounting_invoice_id) + 1) AS mxaccid FROM accounting_invoices where quotation_sr_no like concat('%', '$quot1')"); // Get the ID Value form database
       
        $mxaccidValue = $mxaccid[0]->mxaccid;
	if($mxaccidValue == '') { $mxaccidValue = 1; }
	if($mxaccidValue < 10) {
                $mxaccidValue = '00'.$mxaccidValue;
        } elseif($mxaccidValue >=10 and $mxaccidValue < 100) {
                $mxaccidValue = '0'.$mxaccidValue;
        } elseif($mxaccidValue >= 100) {
                $mxaccidValue = $mxaccidValue;
        }

        $financial_year = date("Y") . "-" . date("m"); // Current Month and Year for Month column


      //  $quot = "/" . date("y") . "-" . date("y", strtotime('+1 year'));
        $quotation_sr_no = "CMQ" . $mxaccidValue . $quot; // Create Quotation serial number using id value 
        $submit_date = date("Y-m-d H:i:s");
        $gst_status = 'Y';
        $session_id = Auth::id();



        // GET the given input values and store into database
        $invoice_activity_status = $request->input('quota_client_particulars');
        $particulars =strtoupper($invoice_activity_status);
        $invoice_material_code = $request->input('quota_client_material');
        $quota_client_location = '0';

	$quota_submitted_name = $request->input('quota_submitted_name');
        $quot_type = $request->input('quot_type');

        $quota_company_name = $request->input('quota_company_name');
        $quota_contact_person_hidden = $request->input('quota_contact_person_hidden');

        $quota_client_address_hidden = $request->input('quota_client_address_hidden');
        $quota_client_address_hidden_2 = $request->input('quota_client_address_hidden_2');
        $quota_client_address_hidden_3 = $request->input('quota_client_address_hidden_3');
        $quota_client_address_hidden_4 = $request->input('quota_client_address_hidden_4');
        $quota_client_location_hidden = $request->input('quota_client_location_hidden');
        $client_location =strtoupper($quota_client_location_hidden);
        $quota_client_state_hidden = $request->input('quota_client_state_hidden');
        $client_state =strtoupper($quota_client_state_hidden);
        $quota_client_pincode_hidden = $request->input('quota_client_pincode_hidden');

        $quota_client_id = $request->input('quota_client_name');
	$quota_bank_name = $request->input('quota_bank_name');
        
	$quota_remarks = $request->input('quota_remarks');
        $quotation_remarks =strtoupper($quota_remarks);
	$quota_remarks2 = $request->input('quota_remarks_2');
        $quotation_remarks_2 =strtoupper($quota_remarks2);
        $payment_date = $request->input('payment_date');
        $payment_status = $request->input('payment_status');
        $payment_received = $request->input('payment_received');

        $hid_prdqty = $request->input('hid_prdqty');
        $product_quantity = number_format((float) $hid_prdqty, 2, '.', ''); // Round off the value and stored into database
        $hid_prdrate = $request->input('hid_prdrate');
        $product_rate = number_format((float) $hid_prdrate, 2, '.', '');
        $hid_prdgstpercentage = $request->input('hid_prdgstpercentage');
        $product_gst = number_format((float) $hid_prdgstpercentage, 2, '.', '');
        $hid_prdtotalamount = $request->input('hid_prdtotalamount');
        $product_total = number_format((float) $hid_prdtotalamount, 2, '.', '');

        $hid_prdqty = $request->input('hid_prdqty');
        $hid_prdrate = $request->input('hid_prdrate');
        $hid_prdgstpercentage = $request->input('hid_prdgstpercentage');
        $hid_prdtotalamount = $request->input('hid_prdtotalamount');

        // Get all values in array and insert the values in DB Table
        $data = array(
            'financial_year' => $financial_year,
            'user_id' => $session_id,
	    'bank_master_id' => $quota_bank_name,
            'quotation_sr_no' => $quotation_sr_no,
            'quotation_submitted_by' => $quota_submitted_name,
            'quotation_type' => $quot_type,
	    'quotation_remarks' => $quota_remarks,
	    'quotation_remarks_2' => $quota_remarks2,
            'billing_location_id' => $quota_client_location,
            'company_id' => $quota_client_id,
            'company_address' => $quota_client_address_hidden,
            'company_address_2' => $quota_client_address_hidden_2,
            'company_address_3' => $quota_client_address_hidden_3,
            'company_address_4' => $quota_client_address_hidden_4,
            'company_location' => $client_location,
            'activity' => $quota_company_name,
            'contact_person' => $quota_contact_person_hidden,
            'company_state' => $client_state,
            'company_pincode' => $quota_client_pincode_hidden,
            'activity_details' => $particulars,
            'material_code' => $invoice_material_code,
            'submit_date' => $submit_date,
	    'entry_status' => 'Y',
            'gst_status' => $gst_status,
	    'accounting_invoice_status' => 'N',
            'payment_status' => $payment_status,
            'payment_date' => $payment_date,
            'payment_received' => $payment_received,
            'sub_total_amount' => ($product_rate * $product_quantity),
            'quantity' => $product_quantity,
            'rate' => $product_rate,
            'gst_percentage' => $product_gst,
            'gst_amount' => ($product_total - ($product_rate * $product_quantity)),
            'total_amount' => $product_total,
            'created_at' => $submit_date,
            'updated_at' => $submit_date
        );

         DB::table('accounting_invoices')->insert($data); // Insert data into database table

        // Contact input values
        $quota_company_contact_user = $request->input('quota_company_contact_user');
        $quota_company_phone = $request->input('quota_company_phone');
        $quota_company_email = $request->input('quota_company_email');
        $primary_status ='P';
        $contact_entry_date = date("Y-m-d H:i:s");
        $quota_contact_person_secondary = $request->input('quota_contact_person_secondary');
        $quota_contact_no_secondary = $request->input('quota_contact_no_secondary');
        $quota_company_email_secondary = $request->input('quota_company_email_secondary');
        $secondary_status = 'S';

        $contact = array(

            'accounting_invoice_id' => $mxaccidValue,
            'contact_name' => $quota_company_contact_user,
            'contact_mobile' => $quota_company_phone,
            'contact_email' => $quota_company_email,
            'contact_type' => $primary_status,
            'contact_entry_date' => $contact_entry_date,
            'contact_status' => 'Y',
            'created_at' => $contact_entry_date,
            'updated_at' => $contact_entry_date

        );

        DB::table('accounting_invoice_contact')->insert($contact);

        $max_count = count($quota_contact_person_secondary); 

        for ($x = 0; $x < $max_count; $x++) {

            if (
                !empty($quota_contact_person_secondary[$x]) &&
                !empty($quota_contact_no_secondary[$x]) &&
                !empty($quota_company_email_secondary[$x])
            ) {
                $contact1 = array(
                    'accounting_invoice_id' => $mxaccidValue,
                    'contact_name' => $quota_contact_person_secondary[$x],
                    'contact_mobile' => $quota_contact_no_secondary[$x],
                    'contact_email' => $quota_company_email_secondary[$x],
                    'contact_type' => $secondary_status,
                    'contact_entry_date' => $contact_entry_date,
                    'contact_status' => 'Y',
                    'created_at' => $contact_entry_date,
                    'updated_at' => $contact_entry_date
                );
        
               DB::table('accounting_invoice_contact')->insert($contact1);
            }
        }

        // Product input values
        $invoice_product_name = $request->input('invoice_product_name');
        $invoice_quality = $request->input('invoice_quality');
        $invoice_rate = $request->input('invoice_rate');
        $invoice_rate_hidden = $request->input('invoice_rate');
        $invoice_gst = $request->input('invoice_gst');
        $invoice_total = $request->input('invoice_total');

        $upd_subtotal = 0;
        $upd_peramount = 0;
        $max = count($invoice_quality); // Product quantity count
        for ($x = 0; $x < $max; $x++) { // Product quantity calculation in loop 

            // Get all values in array and insert the values in DB Table
            $data1 = array(
                'accounting_invoice_id' => $mxaccidValue,
                'product_master_id' => $invoice_product_name[$x],
                'product_rate' => $invoice_rate_hidden[$x],
                'prd_qty' => $invoice_quality[$x],
                'prd_subtotal_amount' => ($invoice_rate[$x] * $invoice_quality[$x]),
                'prd_gst_percentage' => $invoice_gst[$x],
                'prd_gst_amount' => ($invoice_total[$x] - ($invoice_rate[$x] * $invoice_quality[$x])),
                'prd_total_amount' => $invoice_total[$x],
                'accinvprd_status' => 'Y',
                'accinvprd_entry_date' => '$submit_date',
                'created_at' => $submit_date,
                'updated_at' => $submit_date
            );
            // Insert data into the table
            DB::table('accounting_invoice_products')->insert($data1);

            // Sub total and Gst amount calculation
            $upd_subtotal += ($invoice_rate[$x] * $invoice_quality[$x]);
            $upd_peramount += ($invoice_total[$x] - ($invoice_rate[$x] * $invoice_quality[$x]));
        }
        // Sub total and Gst amount values update in DB Table
        $pay_del = array('sub_total_amount' => $upd_subtotal, 'gst_amount' => $upd_peramount);
        DB::enableQueryLog();
        $qry = DB::table('accounting_invoices')
            ->where('accounting_invoice_id', $mxaccidValue)
            ->update($pay_del);

        // If the conditions are success. Quotation pdf generate and return Success pop up
        Session::flash('quotation_pdf', 'quotation_pdf/' . $mxaccidValue);
        return Redirect::to('create_invoice')->with('success', 'Quotation Generated Successfully');

    }

    public function savePayment(Request $request) // Payment details popup function
    {
        // Get file value in condition 
        if ($request->file()) {

            $payment_file = $request->file('payment_attachment');

            foreach ($payment_file as $payment) { // In array the value is stored in variable
                $payfileName = time() . '' . 'payment' . '' . $payment->getClientOriginalName(); // The given file name modified with current time and "payment" unic name
                $payment->move(public_path('uploads'), $payfileName); // The modified file name stored in Public path
            }

        }else{
            $payfileName ='';
        }

        // GET the given input values and store into database
        $rdo_po_received = $request->input('rdo_po_received');
        $rdo_po_method = $request->input('rdo_po_method');
        $rdo_po_status = $request->input('rdo_po_status');
        $paymentdate = $request->input('paymentdate');
        $rdo_po_remark = $request->input('rdo_po_remark');
        $payment_attachment = $request->input('payment_attachment');
        $hidd_accounting_invoice_id = $request->input('hidd_accounting_invoice_id');

        // Get all values in array and insert the values in DB Table
        if($payfileName != ''){
        $pay_del = array(
            'payment_status' => $rdo_po_received,
            'payment_method' => $rdo_po_method,
            'payment_received' => $rdo_po_received,
            'payment_date' => $paymentdate,
            'remarks' => $rdo_po_remark,
            'payment_attachment' => $payfileName
        );
    }else{
        $pay_del = array(
            'payment_status' => $rdo_po_received,
            'payment_method' => $rdo_po_method,
            'payment_received' => $rdo_po_received,
            'payment_date' => $paymentdate,
            'remarks' => $rdo_po_remark,
        );
    }
        DB::enableQueryLog();
        $qry = DB::table('accounting_invoices')
            ->where('accounting_invoice_id', $hidd_accounting_invoice_id)
            ->update($pay_del); // Update values in database

        return view('summary_list');
    }

public function editClient(Request $request){

    $name = $request->input('name');
    $c_name =strtoupper($name);
    $company_address = $request->input('company_address');
    $com_address =strtoupper($company_address);
    $company_address_2 = $request->input('company_address_2');
    $com_address2 =strtoupper($company_address_2);
    $company_address_3 = $request->input('company_address_3');
    $com_address3 =strtoupper($company_address_3);
    $company_address_4 = $request->input('company_address_4');
    $com_address4 =strtoupper($company_address_4);
    $company_location = $request->input('company_location');
    $city_name =strtoupper($company_location);
    $company_state = $request->input('company_state');
    $city_state_name =strtoupper($company_state);
    $company_pincode = $request->input('company_pincode');
    $gst_no = $request->input('gst_no');
    $company_contact_user = $request->input('company_contact_user');
    $contact_name =strtoupper($company_contact_user);
    $company_phone = $request->input('company_phone');
    $company_email = $request->input('company_email');
    $contact_person_secondary = $request->input('contact_person_secondary');
    $contact_no_secondary = $request->input('contact_no_secondary');
    $company_email_secondary = $request->input('company_email_secondary');
    $company_id = $request->input('company_id');
    $sumbit_name = $request->input('sumbitted_name');

  if($c_name != '' && $com_address != '' && $gst_no != '' && $company_contact_user != '' && $company_location != ''){
    $editcilent = array('company_name' => $c_name, 'company_address' => $com_address,'company_address_2' => $com_address2, 'company_address_3' => $com_address3,
    'company_address_4' => $com_address4, 'company_location' => 
$city_name,'company_state' => $city_state_name,'company_pincode' => $company_pincode,'gst_no' => $gst_no,'company_contact_user' => $contact_name,'company_phone' =>
$company_phone,'company_email' => $company_email,'contact_person_secondary' => $contact_person_secondary,'contact_no_secondary' => $contact_no_secondary,'company_email_secondary' =>
$company_email_secondary, 'submitted_name' => $sumbit_name);
    DB::enableQueryLog();
    $qry = DB::table('company_masters')
        ->where('user_id', $company_id)
        ->update($editcilent);

    return Redirect::to('customer')->with('success', 'Client details updated Successfully');
  }
     
  return view('editclient');
  // return redirect()->back();
}

    public function customer_delete(Request $request) // Delete client option 
    {

        $company_id = $request->input('user_id'); // Get the ID value 

        $company_status = 'N';

        $delete = array('company_status' => $company_status);

        DB::enableQueryLog();
        $update = DB::table('company_masters')
            ->where('user_id', $company_id)
            ->update($delete); // Values updated in DB


        return view('customer');

    }

    public function quotation_delete(Request $request) // Delete client option
    {

        $invoice_id = $request->input('invoice_id'); // Get the ID value

        $invoice_status = 'D';

        $delete = array('entry_status' => $invoice_status);

        DB::enableQueryLog();
        $update = DB::table('accounting_invoices')
            ->where('accounting_invoice_id', $invoice_id)
            ->update($delete); // Values updated in DB


        return view('summary_list');

    }

    public function saveInvoice(Request $request) // Invoice details update function 
    {
        $quot = "/" . date("y") . "-" . date("y", strtotime('+1 year'));
        // Create Invoice serial number using id value
        $invoice_sr_no = "CM" . $request->input('hid_accounting_invoice_id') . $quot;
        $submit_date2 = date("Y-m-d H:i:s");

        $txt_po_details = $request->input('txt_po_details');
        $hid_accounting_invoice_id = $request->input('hid_accounting_invoice_id');

        // Values are stored in array
        $pop = array('po_details' => $txt_po_details, 'invoice_sr_no' => $invoice_sr_no, 'accounting_invoice_entdate' => $submit_date2);

        DB::enableQueryLog();
        $qry = DB::table('accounting_invoices')
            ->where('accounting_invoice_id', $hid_accounting_invoice_id)
            ->update($pop); // Values updated in DB

        return view('invoice');

    }

    public function filing_upload(Request $request) // Gst file upload function
    {
        $request->validate([
            // File validation for filing_upload
            'filing_upload' => 'required|array',
            'filing_upload.*' => 'mimes:pdf,jpg,png|max:2048'
        ]);

        if ($request->file()) { // File value check in condition 
            $files = $request->file('filing_upload');
            foreach ($files as $file) { // In array the value is stored in variable
                $fileName = time() . '_' . 'filing' . '_' . $file->getClientOriginalName(); // The given file name modified in current time and "_filing_" unic name
                $file->move(public_path('uploads'), $fileName); // The file Stored in public path
            }

            $hidddd_accounting_invoice_id = $request->input('hidddd_accounting_invoice_id');

            $file_upload = array('filing_upload' => $fileName, 'filing_status' => 'Y');

            $qry = DB::table('accounting_invoices')
                ->where('accounting_invoice_id', $hidddd_accounting_invoice_id)
                ->update($file_upload); // Value stored in DB

        }

        return view('invoice');

    }

    public function filing_upload_1(Request $request) // Extra function for checking
    {
        $request->validate([
            'filing_upload' => 'required|array',
            'filing_upload.*' => 'mimes:pdf,jpg,png|max:2048'
        ]);

        if ($request->file()) {
            $files = $request->file('filing_upload');
            foreach ($files as $file) {
                $fileName = time() . '_' . 'filing' . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName);
            }

            $hidddd_accounting_invoice_id = $request->input('hidddd_accounting_invoice_id');

            $file_upload = array('filing_upload' => $fileName, 'filing_status' => 'Y');

            $qry = DB::table('accounting_invoices')
                ->where('accounting_invoice_id', $hidddd_accounting_invoice_id)
                ->update($file_upload);

        }

        return view('home');

    }

    public function filingStatus(Request $request) // File status upload function 
    {
        // Get input values 
        $rdo_file_received = $request->input('rdo_file_received');
        $hiddd_accounting_invoice_id = $request->input('hiddd_accounting_invoice_id');

        $call_filing = array('filing_status' => $rdo_file_received); // Stored in array

        DB::enableQueryLog();
        $qry = DB::table('accounting_invoices')
            ->where('accounting_invoice_id', $hiddd_accounting_invoice_id)
            ->update($call_filing); // Values are stored in DB

        return view('invoice');

    }

    public function fileExport()
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }

    public function create_invoice() // Create Quotation Form 
    {
        // Admin and Sales team only access this page
        if (Auth::id() == '') {
            return redirect()->route('login');
        }
        if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
            return redirect()->route('home');
        }
        // Get id and name in array from Master_cities Model file
        $configuraciones = Master_cities::select('id', 'name')->get()->toArray();
        // Get id and name in array from Product_master Model file
        $product_name = Product_master::select('product_master_id', 'product_master_name')->get()->toArray();
        // Get id, name and location in array from Company_master Model file
        $company_name_value = Company_master::select('user_id', 'company_name', 'company_location')->where('company_status', '<>', 'N')->get()->toArray();

        return view('create_invoice', ['configuraciones' => $configuraciones, 'product_name' => $product_name, 'company_name_value' => $company_name_value]);
    }

    public function store(Request $request)
    {

        if (Auth::id() == '') {
            return redirect()->route('login');
        }
	
	if($_SERVER['QUERY_STRING'] != '') {
		$mxaccid = DB::select('SELECT invoice_sr_no FROM accounting_invoices where accounting_invoice_id = '.$_SERVER['QUERY_STRING']); // Get the ID Value form database
        	if($mxaccid[0]->invoice_sr_no != '') {
			return redirect()->route('home');
		}
	}

        if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
            return redirect()->route('home');
        }

        // Edit client input values
        $quot_accounting_invoice_id = $request->input('quota_no1');
        $quota_client_name = $request->input('quota_client_name');
        $quota_client_address = $request->input('quota_client_address');
        $quota_client_address_2 = $request->input('quota_client_address_2');
        $quota_client_address_3 = $request->input('quota_client_address_3');
        $quota_client_address_4 = $request->input('quota_client_address_4');
        $quota_client_location = $request->input('quota_client_location');
        $quota_client_state = $request->input('quota_client_state');
        $quota_client_pincode = $request->input('quota_client_pincode');
        $quota_client_particulars = $request->input('quota_client_particulars');
        $quota_client_material = $request->input('quota_client_material');
        $quot_type = $request->input('quot_type');
        $quota_submitted_name = $request->input('quota_submitted_name');
	$quota_remarks = $request->input('quota_remarks');
        $quotation_remarks =strtoupper($quota_remarks);
	$quota_remarks2 = $request->input('quota_remarks_2');
        $quotation_remarks_2 =strtoupper($quota_remarks2);
	$quota_bank_name = $request->input('quota_bank_name');

// echo "!!".$quota_client_name."!!".$quota_client_state."!!".$quota_client_address."!!".$quota_client_particulars."!!".$quota_client_material."!!";
        // The client values are Not null. The values are stored in array 
        if ($quota_client_name != '' && $quota_client_state != '' && $quota_client_address != '' && $quota_client_particulars != '') {
            
// echo "=="; exit;
            $editquot = array('activity' => $quota_client_name, 'company_address' => $quota_client_address, 'company_address_2' => $quota_client_address_2, 'company_address_3' => $quota_client_address_3,
            'company_address_4' => $quota_client_address_4,
            'company_location' => $quota_client_location, 'company_state' => $quota_client_state, 'company_pincode' => $quota_client_pincode, 'activity_details' => $quota_client_particulars, 'material_code' => $quota_client_material,'quotation_submitted_by' => $quota_submitted_name,'quotation_type' => $quot_type, 'quotation_remarks' => $quota_remarks, 'quotation_remarks_2' => $quota_remarks2, 'bank_master_id' => $quota_bank_name);

            DB::enableQueryLog();
            $qry = DB::table('accounting_invoices')
                ->where('accounting_invoice_id', $quot_accounting_invoice_id)
                ->update($editquot); // Stored values updated in database 

          
            // Product input values
            $invoice_product_name = $request->input('invoice_product_name');
            $invoice_quality = $request->input('invoice_quality');
            $invoice_rate = $request->input('invoice_rate');
            $invoice_rate_hidden = $request->input('invoice_rate');
            $invoice_gst = $request->input('invoice_gst');
            $invoice_total = $request->input('invoice_total');
            $invoice_accinvprd_id = $request->input('invoice_accinvprd_id');

            

            $upd_subtotal = 0;
            $upd_peramount = 0;
            $inv_qlty=0;
            $inv_rate=0;
            $inv_gst=0;
            $inv_total=0;
            
            $max = count((array) $invoice_quality);// Product quantity count
            for ($x = 0; $x < $max; $x++) { // Product quantity calculation in loop 

               
                // Get all values in array and insert the values in DB Table
                if ($invoice_quality != '' && $invoice_rate != '') {
                    $inv_qlty+=$invoice_quality[$x];
                    $inv_rate+=$invoice_rate_hidden[$x];
                    $inv_gst+=$invoice_gst[$x];
                    $inv_total+=$invoice_total[$x];
                    $data1 = array(
                        'accounting_invoice_id' => $quot_accounting_invoice_id,
                        'product_master_id' => $invoice_product_name[$x],
                        'product_rate' => $invoice_rate_hidden[$x],
                        'prd_qty' => $invoice_quality[$x],
                        'prd_subtotal_amount' => ($invoice_rate[$x] * $invoice_quality[$x]),
                        'prd_gst_percentage' => $invoice_gst[$x],
                        'prd_gst_amount' => ($invoice_total[$x] - ($invoice_rate[$x] * $invoice_quality[$x])),
                        'prd_total_amount' => $invoice_total[$x],
                        'accinvprd_status' => 'Y',

                    );
                  
                    // Insert data into the table
                    DB::enableQueryLog();
                    $qry2 = DB::table('accounting_invoice_products')
                        ->where('accinvprd_id', $invoice_accinvprd_id[$x])
                        ->update($data1);

                }
          
                $upd_subtotal += ($invoice_rate[$x] * $invoice_quality[$x]);
                $upd_peramount += ($invoice_total[$x] - ($invoice_rate[$x] * $invoice_quality[$x]));

                $inv_qaty = number_format((float) $inv_qlty, 2, '.', '');
                $inv_rates = number_format((float) $inv_rate, 2, '.', '');
                $inv_gsts = number_format((float) $inv_gst, 2, '.', '');
                $inv_totals = number_format((float) $inv_total, 2, '.', '');

            }


            $pay_del = array('sub_total_amount' => $upd_subtotal, 'gst_amount' => $upd_peramount, 'quantity' => $inv_qaty,'rate' => $inv_rates,'gst_percentage' => $inv_gsts,'total_amount' => $inv_totals);

            DB::enableQueryLog();
            $qry3 = DB::table('accounting_invoices')
                ->where('accounting_invoice_id', $quot_accounting_invoice_id)
                ->update($pay_del);

	  // Contact input values
           
           $h_primary_acc_inv_contact_id = $request->input('h_primary_acc_inv_contact_id');
           $quota_company_contact_user = $request->input('quota_company_contact_user');
           $quota_company_phone = $request->input('quota_company_phone');
           $quota_company_email = $request->input('quota_company_email');
           $primary_status ='P';
           $contact_entry_date = date("Y-m-d H:i:s");
           $quota_contact_person_secondary = $request->input('quota_contact_person_secondary');
           $quota_contact_no_secondary = $request->input('quota_contact_no_secondary');
           $quota_company_email_secondary = $request->input('quota_company_email_secondary');
           $secondary_status = 'S';

        $contact = array(

            'accounting_invoice_id' => $quot_accounting_invoice_id,
            'contact_name' => $quota_company_contact_user,
            'contact_mobile' => $quota_company_phone,
            'contact_email' => $quota_company_email,
            'contact_type' => $primary_status,
            'contact_entry_date' => $contact_entry_date,
            'contact_status' => 'Y',
            'created_at' => $contact_entry_date,
            'updated_at' => $contact_entry_date

        );

        // DB::table('accounting_invoice_contact')->insert($contact);

        DB::enableQueryLog();
        $qry3 = DB::table('accounting_invoice_contact')
            ->where('acc_inv_contact_id', $h_primary_acc_inv_contact_id)
            ->update($contact);
            
        
            $max_count = 0; // Initialize max_count

            $quota_contact_person_secondary = $request->input('quota_contact_person_secondary'); // Assuming this is where you get the array from
            
            if (is_array($quota_contact_person_secondary)) {
                $max_count = count($quota_contact_person_secondary);
            }
            
            $h_acc_inv_contact_id = $request->input('h_acc_inv_contact_id'); // Replace with your unique ID logic
            
            for ($x = 0; $x < $max_count; $x++) {
                $contact1 = array(
                    'accounting_invoice_id' => $quot_accounting_invoice_id,
                    'contact_name' => $quota_contact_person_secondary[$x],
                    'contact_mobile' => $quota_contact_no_secondary[$x],
                    'contact_email' => $quota_company_email_secondary[$x],
                    'contact_type' => $secondary_status,
                    'contact_entry_date' => $contact_entry_date,
                    'contact_status' => 'Y',
                    'created_at' => $contact_entry_date,
                    'updated_at' => $contact_entry_date
                );
            
                if (isset($h_acc_inv_contact_id[$x]) && isset($quota_contact_person_secondary[$x]) && isset($quota_contact_no_secondary[$x]) && isset($quota_company_email_secondary[$x])) {
                    DB::enableQueryLog();
                    $qry4 = DB::table('accounting_invoice_contact')
                        ->where('acc_inv_contact_id', $h_acc_inv_contact_id[$x])
                        ->update($contact1);
                } else {
                    DB::table('accounting_invoice_contact')->insert($contact1);
                }
            }
            

                return view('summary_list');
                
        }
// echo "::"; // exit;

        // Get id and name in array from Master_cities Model file
        $configuraciones = Master_cities::select('id', 'name')->get()->toArray();
        // Get id and name in array from Product_master Model file
        $product_name = Product_master::select('product_master_id', 'product_master_name')->get()->toArray();

        // Get id, name and location in array from Company_master Model file
        $company_name_value = Company_master::select('user_id', 'company_name', 'company_location')->where('company_status', '<>', 'N')->get()->toArray();

        $company_name_value1 = Accounting_invoice::select('accounting_invoice_id', 'activity', 'company_location', 'quotation_sr_no')->get()->toArray();

        return view('edit_quotation', ['configuraciones' => $configuraciones, 'product_name' => $product_name, 'company_name_value' => $company_name_value, 'company_name_value1' => $company_name_value1]);

    }
    public function cancel()
    {
        $command = "pkill -9 Copy";
        shell_exec($command);

        return view('create_invoice');

    }

}
