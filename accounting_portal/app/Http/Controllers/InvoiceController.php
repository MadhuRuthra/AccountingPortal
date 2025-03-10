<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\Accounting_invoice;
use DB;
use PDF;
use App\Models\Company_master;

class InvoiceController extends Controller
{
    public function invoice(Request $request)
    {
        if (Auth::id() == '') {
            return redirect()->route('login');
        }

        // Get data from database using queries
        $data = DB::table('accounting_invoices as ai')
		->join('company_masters as cm', 'ai.company_id', '=', 'cm.user_id')  
            ->select(
                'ai.*','cm.gst_no', DB::raw("FORMAT(ai.quantity, 2, 'en_IN') AS quantity_format"), DB::raw("FORMAT(ai.rate, 2, 'en_IN') AS rate_format"), DB::raw("FORMAT(ai.sub_total_amount, 2, 'en_IN') AS sub_total_amount_format"), DB::raw("FORMAT(ai.gst_amount, 2, 'en_IN') AS gst_amount_format"), DB::raw("FORMAT(ROUND(ai.total_amount), 2, 'en_IN') AS total_amount_format"), DB::raw("CONCAT(ai.po_details, ',\n', ai.invoice_sr_no) AS po_invoice"), DB::raw("CONCAT('Payment Status: ', CASE WHEN ai.payment_status = 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END, '\nPayment Received: ', CASE WHEN ai.payment_received = 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END) AS payment_details"),
                DB::raw("CASE WHEN ai.received_date IS NULL THEN '-' ELSE ai.received_date END AS received_dates"),
                DB::raw("CASE WHEN ai.invoice_sr_no IS NULL THEN '-' ELSE ai.invoice_sr_no END AS invoice_sr_num"),DB::raw("CASE ai.filing_status WHEN 'Y' THEN 'GST FILED' WHEN 'N' THEN 'GST NOT FILED' ELSE 'GST NOT FILED' END AS gst_statuses")
            );

        if ($request->ajax()) { // using ajax to get values for Search bar and date filter

            return Datatables::of($data) // return datas Datatables
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if ($request->input('search.value') != "") { // search bar condition
    
                        $instance->where(function ($w) use ($request) {
                            // column values get in query for search filter
                            $w->whereRaw("received_date like '%{$request->input('search.value')}%' or activity_details like '%{$request->input('search.value')}%' or FORMAT(ai.quantity, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.rate, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.sub_total_amount, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.gst_amount, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.total_amount, 2, 'en_IN') like '%{$request->input('search.value')}%' or submit_date like '%{$request->input('search.value')}%' or quotation_sr_no like '%{$request->input('search.value')}%' or invoice_sr_no like '%{$request->input('search.value')}%'");

                        });

                    }
                    // Date filter function for From date and To date
                    if (empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // if Double output given. else part provide From to To date filtered data

                        $instance = Accounting_invoice::get();

                    } elseif (!empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 
    
                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {

                            $w->whereDate(DB::raw('DATE(received_date)'), '=', $detail_end_date);
                        })->get()->all();

                    } elseif (empty($request->get('detail_to_date')) && !empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 
    
                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(received_date)'), '=', $detail_from_date);
                        })->get()->all();

                    } else { // if Double output given. else part provide From to To date filtered data
                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(received_date)'), '>=', $detail_from_date)
                                ->whereDate(DB::raw('DATE(received_date)'), '<=', $detail_end_date);
                        })->get()->all();
                    }

                })
                 // Download buton for invoice pdf
                ->addColumn('action', function ($datas) {
                    if ($datas->invoice_sr_no == '') { // if invoice not create. This button not display in list 
                        return '-';
                    } else {
                        return '

                        <a href="' . route('quotation_pdf', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-success" title="Download Quotation" style=" width: 50px;
                        margin-top:2px;"><svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 10px; " width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5
                        9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0
                        0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path> </svg></a><br>

			<a title="Download Invoice" href="' . route('invoice_pdf', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-primary" style=" width: 50px; margin-top:2px;"><svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 10px; " width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5
9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0
0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path> </svg></a>
        	    ';
                    }
                })
                // file upload button for invoice
                ->addColumn('filing_upload', function ($data) {
                    if (Auth::user()->user_master_id == 2) { // Sales team access only for this operation 
                        $filingStatus = DB::table('accounting_invoices as ai')
                            ->select(DB::raw("CASE WHEN ai.filing_status = 'Y' THEN 'GST FILED' ELSE 'GST NOT FILED' END AS filing_upload"))
                            ->where('ai.accounting_invoice_id', $data->accounting_invoice_id)
                            ->first();

                        if ($data->filing_upload != '') { // file is already uploaded download button display on this list
                            return '
	                  <a href="public/uploads/' . $data->filing_upload . '" download  class="btn btn-xs btn-dark downloadbutton" style="width: 172px; margin-bottom: 1px; border: 1px solid #000 !important; border-radius: 50px; " title="GST Filed Attachment Download">Download File</a>
                  	';
                        } else {
                            return $filingStatus->filing_upload;  // file is empty upload button display on this list
                        }
                    } else { // Other teams access the Gst file attachments
                        $filingStatus = DB::table('accounting_invoices as ai')
                            ->select(DB::raw("CASE WHEN ai.filing_status = 'Y' THEN 'GST FILED' ELSE 'GST NOT FILED' END AS filing_upload"))
                            ->where('ai.accounting_invoice_id', $data->accounting_invoice_id)
                            ->first();

                        if ($data->filing_upload != '') {
                            return '
                  <a title="GST Filed Attachment Download" href="public/uploads/' . $data->filing_upload . '" download  class="btn btn-xs btn-dark downloadbutton" style="width: 172px; margin-bottom: 2px; margin-top:2px;">Download File</a>
                  ';
                        } else {
                            return '
                  <a href="#" title="Upload GST Attachment" class="btn btn-xs btn-dark downloadbutton" style="width: 172px; margin-bottom: 2px; margin-top:2px; border: 1px solid #000 !important; border-radius: 50px;" onclick="filing_upload(' . $data->accounting_invoice_id . ')">Upload File</a>
                ';
                        }

                    }
                })
                ->rawColumns(array("action", "filing_upload")) // used to display two columns with button
                ->make(true);
        }

        return view('invoice');
    }

    //PDF generation for Quotation
    public function quotationPDF($accounting_invoice_id)
    {
        //account_invoices table data
        $invoice_data = DB::table('accounting_invoices as ai')
            ->select('ai.*', DB::raw("FORMAT(ROUND(ai.total_amount, 0), 2, 'en_IN') AS total_amount_format"))
            ->where('accounting_invoice_id', $accounting_invoice_id)
            ->get();


        $company_id = $invoice_data->pluck('company_id');

        //company_masters table data
        $company_data = DB::table('company_masters')
            ->where('user_id', $company_id)
            ->get();


	$bank = Accounting_invoice::select('bank_masters.company_name', 'bank_masters.bank_name', 'bank_masters.bank_account_no', 'bank_masters.bank_ifsc_code')
            ->join('bank_masters', 'accounting_invoices.bank_master_id', '=', 'bank_masters.bank_master_id')
            ->where('accounting_invoice_id', $accounting_invoice_id)
            ->get();

        // Get data from database using queries
        $product_data = DB::table('accounting_invoices AS acc_inv')
            ->select('pro_mas.*', 'acc_inv_pro.*', DB::raw("FORMAT((acc_inv_pro.prd_qty * acc_inv_pro.product_rate), 2, 'en_IN') AS product_rate_multiply_format"), DB::raw("FORMAT(acc_inv_pro.product_rate, 2, 'en_IN') AS product_rate_format"), DB::raw("FORMAT(acc_inv_pro.prd_gst_amount, 2, 'en_IN') AS prd_gst_amount_format"), DB::raw("FORMAT(acc_inv_pro.prd_total_amount, 2, 'en_IN') AS prd_total_amount_format"), DB::raw("FORMAT(acc_inv_pro.prd_qty, 0, 'en_IN') AS prd_qty_format"), DB::raw("FORMAT(acc_inv_pro.prd_subtotal_amount, 2, 'en_IN') AS prd_subtotal_amount_format"))
            ->join('accounting_invoice_products AS acc_inv_pro', 'acc_inv.accounting_invoice_id', '=', 'acc_inv_pro.accounting_invoice_id')
            ->join('product_masters AS pro_mas', 'acc_inv_pro.product_master_id', '=', 'pro_mas.product_master_id')
            ->where('acc_inv.accounting_invoice_id', $accounting_invoice_id)
            ->get();

        // Total Amount in Words function
        $number = round($invoice_data[0]->total_amount,0);
        /* $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array( // Number to String conversion 

            '0' => 'zero',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
            '20' => 'twenty',
            '30' => 'thirty',
            '40' => 'forty',
            '50' => 'fifty',
            '60' => 'sixty',
            '70' => 'seventy',
            '80' => 'eighty',
            '90' => 'ninety'

        );
        // using array to get values
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) { // Run values in while loop 
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
            " " . $words[floor($point / 10) * 10] . " " .
            $words[$point = $point % 10] : '';
        if ($points != '') { // Output in points this if part display successfully
            $ttlamt = $result . "Rupees " . $points . " Paise";
        } else { // Output in normal this else part display successfully
            $ttlamt = $result . "Rupees " . $points;
        } */

    $no = (int) floor($number);
    $point = (int) round(($number - $no) * 100);
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
      '0' => '',
      '1' => 'one',
      '2' => 'two',
      '3' => 'three',
      '4' => 'four',
      '5' => 'five',
      '6' => 'six',
      '7' => 'seven',
      '8' => 'eight',
      '9' => 'nine',
      '10' => 'ten',
      '11' => 'eleven',
      '12' => 'twelve',
      '13' => 'thirteen',
      '14' => 'fourteen',
      '15' => 'fifteen',
      '16' => 'sixteen',
      '17' => 'seventeen',
      '18' => 'eighteen',
      '19' => 'nineteen',
      '20' => 'twenty',
      '30' => 'thirty',
      '40' => 'forty',
      '50' => 'fifty',
      '60' => 'sixty',
      '70' => 'seventy',
      '80' => 'eighty',
      '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
      $divider = ($i == 2) ? 10 : 100;
      $number = floor($no % $divider);
      $no = floor($no / $divider);
      $i += ($divider == 10) ? 1 : 2;


      if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str[] = ($number < 21) ? $words[$number] .
          " " . $digits[$counter] . $plural . " " . $hundred
          :
          $words[floor($number / 10) * 10]
          . " " . $words[$number % 10] . " "
          . $digits[$counter] . $plural . " " . $hundred;
      } else
        $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);

    if ($point > 20) {
      $points = ($point) ?
        "" . $words[floor($point / 10) * 10] . " " .
        $words[$point = $point % 10] : '';
    } else {
      $points = $words[$point];
    }
    if ($points != '') {
      $ttlamt = $result . "Rupees  " . $points . " Paise Only";
    } else {
      $ttlamt = $result . "Rupees Only";
    }


        $pdf = PDF::loadView('quotation_pdf', ['invoice_data' => $invoice_data, 'company_data' => $company_data, 'product_data' => $product_data, 'ttlamt' => $ttlamt, 'bank' => $bank]);

        return $pdf->download($invoice_data[0]->quotation_sr_no.'.pdf');

    }
    //PDF generation for Invoice
    public function invoicePDF($accounting_invoice_id)
    {
        //account_invoices table data
        $invoice_data = DB::table('accounting_invoices as ai')
            ->select('ai.*', DB::raw("FORMAT(ROUND(ai.total_amount, 0), 2, 'en_IN') AS total_amount_format"))
            ->where('accounting_invoice_id', $accounting_invoice_id)
            ->get();

	$bank = Accounting_invoice::select('bank_masters.company_name', 'bank_masters.bank_name', 'bank_masters.bank_account_no', 'bank_masters.bank_ifsc_code')
            ->join('bank_masters', 'accounting_invoices.bank_master_id', '=', 'bank_masters.bank_master_id')
            ->where('accounting_invoice_id', $accounting_invoice_id)
            ->get();

        $company_id = $invoice_data->pluck('company_id');

        //company_masters table data
        $company_data = DB::table('company_masters')
            ->where('user_id', $company_id)
            ->get();

        // Get data from database using queries
        $product_data = DB::table('accounting_invoices AS acc_inv')
            ->select('pro_mas.*', 'acc_inv_pro.*', DB::raw("FORMAT((acc_inv_pro.prd_qty * acc_inv_pro.product_rate), 2, 'en_IN') AS product_rate_multiply_format"), DB::raw("FORMAT(acc_inv_pro.product_rate, 2, 'en_IN') AS product_rate_format"), DB::raw("FORMAT(acc_inv_pro.prd_gst_amount, 2, 'en_IN') AS prd_gst_amount_format"), DB::raw("FORMAT(acc_inv_pro.prd_total_amount, 2, 'en_IN') AS prd_total_amount_format"), DB::raw("FORMAT(acc_inv_pro.prd_qty, 0, 'en_IN') AS prd_qty_format"), DB::raw("FORMAT(acc_inv_pro.prd_subtotal_amount, 2, 'en_IN') AS prd_subtotal_amount_format"))
            ->join('accounting_invoice_products AS acc_inv_pro', 'acc_inv.accounting_invoice_id', '=', 'acc_inv_pro.accounting_invoice_id')
            ->join('product_masters AS pro_mas', 'acc_inv_pro.product_master_id', '=', 'pro_mas.product_master_id')
            ->where('acc_inv.accounting_invoice_id', $accounting_invoice_id)
            ->get();

        // Total Amount in Words function
        $number = round($invoice_data[0]->total_amount,0);
        /* $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array( // Number to String conversion 
            '0' => 'zero',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
            '20' => 'twenty',
            '30' => 'thirty',
            '40' => 'forty',
            '50' => 'fifty',
            '60' => 'sixty',
            '70' => 'seventy',
            '80' => 'eighty',
            '90' => 'ninety'
        );
        // using array to get values
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) { // Run values in while loop 
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
            " " . $words[floor($point / 10) * 10] . " " .
            $words[$point = $point % 10] : '';
        if ($points != '') { // Output in points... This if part display successfully
            $ttlamt = $result . "Rupees " . $points . " Paise";
        } else { // Output in normal... This else part display successfully
            $ttlamt = $result . "Rupees " . $points;
        } */

    $no = (int) floor($number);
    $point = (int) round(($number - $no) * 100);
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
      '0' => '',
      '1' => 'one',
      '2' => 'two',
      '3' => 'three',
      '4' => 'four',
      '5' => 'five',
      '6' => 'six',
      '7' => 'seven',
      '8' => 'eight',
      '9' => 'nine',
      '10' => 'ten',
      '11' => 'eleven',
      '12' => 'twelve',
      '13' => 'thirteen',
      '14' => 'fourteen',
      '15' => 'fifteen',
      '16' => 'sixteen',
      '17' => 'seventeen',
      '18' => 'eighteen',
      '19' => 'nineteen',
      '20' => 'twenty',
      '30' => 'thirty',
      '40' => 'forty',
      '50' => 'fifty',
      '60' => 'sixty',
      '70' => 'seventy',
      '80' => 'eighty',
      '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
      $divider = ($i == 2) ? 10 : 100;
      $number = floor($no % $divider);
      $no = floor($no / $divider);
      $i += ($divider == 10) ? 1 : 2;


      if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str[] = ($number < 21) ? $words[$number] .
          " " . $digits[$counter] . $plural . " " . $hundred
          :
          $words[floor($number / 10) * 10]
          . " " . $words[$number % 10] . " "
          . $digits[$counter] . $plural . " " . $hundred;
      } else
        $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);

    if ($point > 20) {
      $points = ($point) ?
        "" . $words[floor($point / 10) * 10] . " " .
        $words[$point = $point % 10] : '';
    } else {
      $points = $words[$point];
    }
    if ($points != '') {
      $ttlamt = $result . "Rupees  " . $points . " Paise Only";
    } else {
      $ttlamt = $result . "Rupees Only";
    }

        $pdf = PDF::loadView('invoice_pdf', ['invoice_data' => $invoice_data, 'company_data' => $company_data, 'product_data' => $product_data, 'ttlamt' => $ttlamt, 'bank' => $bank]);

        return $pdf->download($invoice_data[0]->invoice_sr_no.'.pdf');

    }


}
