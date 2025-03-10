<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Accounting_invoice;
use DB;
use Illuminate\Support\Facades\Auth;

class SummarylistController extends Controller
{
    public function summary(Request $request)
    {
        if (Auth::id() == '') {
            return redirect()->route('login');
        }
        if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
            return redirect()->route('home');
        }



        $data = DB::table('accounting_invoices as ai')
	 //   ->where('entry_status', '=', 'Y')
		 ->join('company_masters as cm', 'ai.company_id', '=', 'cm.user_id')
            ->select(
		  'ai.*','cm.gst_no',
		DB::raw("CONCAT(ai.activity, ' (GST NO : ', cm.gst_no, ')') AS activity_gst"),
                DB::raw("FORMAT(ai.quantity, 2, 'en_IN') AS quantity_format"),
                DB::raw("FORMAT(ai.rate, 2, 'en_IN') AS rate_format"),
                DB::raw("FORMAT(ai.sub_total_amount, 2, 'en_IN') AS sub_total_amount_format"),
                DB::raw("FORMAT(ai.gst_amount, 2, 'en_IN') AS gst_amount_format"),
                DB::raw("FORMAT(ROUND(ai.total_amount, 0), 2, 'en_IN') AS total_amount_format"),
                DB::raw("CASE WHEN ai.po_details IS NULL THEN '-' ELSE ai.po_details END AS po_detail"),
                DB::raw("CASE WHEN ai.received_date IS NULL THEN '-' ELSE ai.received_date END AS received_dates"),
                DB::raw("CASE WHEN ai.invoice_sr_no IS NULL THEN '-' ELSE ai.invoice_sr_no END AS invoice_sr_num"),
                DB::raw("CASE WHEN ai.payment_date IS NULL THEN '-' ELSE ai.payment_date END AS payment_dates"),
                DB::raw("CASE WHEN ai.remarks IS NULL THEN '-' ELSE ai.remarks END AS remark"),
                DB::raw("CASE WHEN ai.start_date IS NULL THEN '-' ELSE CONCAT('Start Date: ', DATE_FORMAT(ai.start_date, '%Y-%m-%d'), ' End Date: ', DATE_FORMAT(ai.end_date, '%Y-%m-%d')) END AS campaign_date"),
                DB::raw("CASE ai.payment_received WHEN 'Y' THEN 'RECEIVED' WHEN 'N' THEN 'NOT RECEIVED' ELSE '' END AS payment_receiveded"),
                DB::raw("CASE ai.filing_status WHEN 'Y' THEN 'GST FILED' WHEN 'N' THEN 'GST NOT FILED' ELSE 'GST NOT FILED' END AS gst_statuses"),
                DB::raw("CASE ai.payment_method WHEN 'C' THEN 'CASH' WHEN 'O' THEN 'ONLINE PAYMENT' WHEN 'Q' THEN 'CHEQUE'  WHEN 'N' THEN '-' ELSE '-' END AS payment_methoded"),
                DB::raw("CASE ai.payment_received
        WHEN 'Y' THEN 'RECEIVED'
        ELSE 
            CASE
                WHEN ai.received_date IS NULL THEN 'INVOICE NOT GENERATED'
                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(ai.received_date, '%Y-%m-%d')) < 30 THEN '< 30'
                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(ai.received_date, '%Y-%m-%d')) < 60 THEN '< 60'
                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(ai.received_date, '%Y-%m-%d')) < 90 THEN '< 90'
                ELSE '> 90'
            END
        END AS days_diff"
                ),
            );



        if ($request->ajax()) {


            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {



                    if ($request->input('search.value') != "") {

                        $instance->where(function ($w) use ($request) {


                            $w->whereRaw("financial_year like '%{$request->input('search.value')}%' or submit_date like '%{$request->input('search.value')}%' or quotation_sr_no like '%{$request->input('search.value')}%' or po_details like '%{$request->input('search.value')}%' or invoice_sr_no like '%{$request->input('search.value')}%' or received_date like '%{$request->input('search.value')}%' or activity like '%{$request->input('search.value')}%' or company_location like '%{$request->input('search.value')}%' or contact_person like '%{$request->input('search.value')}%' or activity_details like '%{$request->input('search.value')}%' or quantity like '%{$request->input('search.value')}%' or rate like '%{$request->input('search.value')}%' or sub_total_amount like '%{$request->input('search.value')}%' or gst_amount like '%{$request->input('search.value')}%' or total_amount like '%{$request->input('search.value')}%' or start_date like '%{$request->input('search.value')}%' or end_date like '%{$request->input('search.value')}%' or gst_status like '%{$request->input('search.value')}%' or payment_status like '%{$request->input('search.value')}%' or payment_date like '%{$request->input('search.value')}%' or payment_method like '%{$request->input('search.value')}%' or remarks like '%{$request->input('search.value')}%' or quotation_submitted_by like '%{$request->input('search.value')}%' or invoice_submitted_by like '%{$request->input('search.value')}%'  or CASE
                                WHEN ai.payment_received = 'Y' THEN 'RECEIVED'
                                ELSE 
                                    CASE
                                        WHEN ai.received_date IS NULL THEN 'INVOICE NOT GENERATED'
                                        WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 30 THEN '< 30'
                                        WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 60 THEN '< 60'
                                        WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 90 THEN '< 90'
                                        ELSE '> 90'
                                    END
                                END like '%{$request->input('search.value')}%' or CASE ai.filing_status WHEN 'Y' THEN 'GST FILED' WHEN 'N' THEN 'GST NOT FILED' ELSE 'GST NOT FILED' END  like '%{$request->input('search.value')}%' or CASE ai.payment_method WHEN 'C' THEN 'CASH' WHEN 'O' THEN 'ONLINE PAYMENT' WHEN 'Q' THEN 'CHEQUE'  WHEN 'N' THEN 'NOT PAID' ELSE '-' END like '%{$request->input('search.value')}%'");
                        });

                    }

                    if (empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) {
                        $instance = Accounting_invoice::get();
                    } elseif (!empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) {

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {

                            $w->whereDate(DB::raw('DATE(submit_date)'), '=', $detail_end_date);
                        })->get()->all();

                    } elseif (empty($request->get('detail_to_date')) && !empty($request->get('detail_from_date'))) {

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(submit_date)'), '=', $detail_from_date);
                        })->get()->all();

                    } else {

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(submit_date)'), '>=', $detail_from_date)
                                ->whereDate(DB::raw('DATE(submit_date)'), '<=', $detail_end_date);
                        })->get()->all();
                    }


                })

                ->addColumn('action', function ($datas) {
                    $receiveddate = $datas->received_date;
                    $paymentdate = $datas->payment_date;
		    if ($datas->entry_status == 'D') {
			return '-';
		}elseif ($datas->entry_status != 'E') {
                    if ($receiveddate != '' && $paymentdate == '') {
                        return '	    
        				<a href="javascript: void(0)" title="Add Payment" class="btn btn-xs btn-danger" style=" width: 50px; margin-bottom: 1px; margin-top:1px;" onclick="call_paydet(' . $datas->accounting_invoice_id . ', \'' . $datas->payment_method . '\', \'' . $datas->remarks . '\', \'' . $datas->payment_received . '\', \'' . $datas->payment_date . '\', \'' . $datas->payment_attachment . '\')"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
</svg></a>
        			';
                    } elseif ($receiveddate != '' && $paymentdate != '') {
			/* return '
                          <a href="javascript: void(0)" title="Edit Payment" class="btn btn-xs btn-primary" style=" width: 50px; margin-bottom: 1px; margin-top:1px;" onclick="call_paydet(' . $datas->accounting_invoice_id . ', \'' . $datas->payment_method . '\', \'' . $datas->remarks . '\', \'' . $datas->payment_received . '\', \'' . $datas->payment_date . '\', \'' . $datas->payment_attachment . '\')"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></a>
                        '; */
			return '
                                        <a href="javascript: void(0)" title="View Payment" class="btn btn-xs btn-success" style=" width: 50px; margin-bottom: 1px; margin-top:1px;"
onclick="call_view_paydet(' . $datas->accounting_invoice_id .', \'' . $datas->payment_method . '\', \'' . $datas->remarks . '\', \'' . $datas->payment_received . '\', \'' . $datas->payment_date . '\',
\'' . $datas->payment_attachment . '\')"><svg width="20" viewBox="0 0 512 512" height="20" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com 
License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32h82.7L201.4 265.4c-12.5
12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3V192c0 17.7 14.3 32 32 32s32-14.3 32-32V32c0-17.7-14.3-32-32-32H320zM80 32C35.8 32 0 67.8 0 112V432c0 44.2 35.8 80 80 80H400c44.2 0 80-35.8
80-80V320c0-17.7-14.3-32-32-32s-32 14.3-32 32V432c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16H192c17.7 0 32-14.3 32-32s-14.3-32-32-32H80z"></path></svg></a>
                                ';
                    } else {
                        return '';
                    }
                }else {
                    return '<b style="color:red !important;">QUOTATION EXPIRED (AND)</b>';
                }
                })

                ->addColumn('download', function ($datas) {
			if ($datas->entry_status == 'D') {
                        return '-';
                }else if ($datas->entry_status != 'E') {
		    if($datas->invoice_sr_no != '') {
			return '<a href="' . route('quotation_pdf', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-success" title="Download Quotation" style=" width: 50px; height: 35px; margin-bottom: 1px;
margin-top:0px;"><svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 10px; " width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5
9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0
0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path> </svg></a>
<br>

<a title="Download Invoice" href="' . route('invoice_pdf', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-primary" style=" width: 50px; height:35px; margin-bottom: 2px; margin-top:2px;"><svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 10px; " width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5
9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0
0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path> </svg></a>';
		    } else {
			return '<a href="' . route('quotation_pdf', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-success" title="Download Quotation" style=" width: 50px; margin-bottom: 2px;
margin-top:0px;"><svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 10px; " width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5
9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0
0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path> </svg></a><br>

<a href="' . route('generate_invoice', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-danger" title="Generate Invoice" style=" width: 50px; margin-bottom: 2px;
margin-top:2px;">
<svg fill="#ffffff" width="22px" height="22px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M18,2H6A2,2,0,0,0,4,4V22l3-3,2,3,3-3,3,3,2-3,3,3V4A2,2,0,0,0,18,2ZM12,16H8a1,1,0,0,1,0-2h4a1,1,0,0,1,0,2Zm0-4H8a1,1,0,0,1,0-2h4a1,1,0,0,1,0,2Zm4,4H15a1,1,0,0,1,0-2h1a1,1,0,0,1,0,2Zm0-4H15a1,1,0,0,1,0-2h1a1,1,0,0,1,0,2Zm0-5H8A1,1,0,0,1,8,5h8a1,1,0,0,1,0,2Z"></path></g></svg>
</a>
';
		    }
        }else{
            return ' - ';
        }
                })

                ->addColumn('payment_attach', function ($datas) {
		if ($datas->entry_status == 'D') {
                        return '-';
                }else if ($datas->entry_status != 'E') {
                    $paymentattach = $datas->payment_attachment;
                    if ($paymentattach != '') {
                        return '
                            <a href="public/uploads/' . $datas->payment_attachment . '" download class="btn btn-xs btn-success" title="Download Attachment" style=" width: 50px; margin-bottom: 1px;
margin-top:0px;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0z"/>
</svg></a>
                    ';
                    } else {
                        return ' - ';
                    }
                }else{
                    return '-';
                }
                })

                ->addColumn('raise_invoice', function ($datas) {
		if ($datas->entry_status == 'D') {
                        return '-';
                }else if ($datas->entry_status != 'E') {
                    $invsrno = $datas->invoice_sr_no;
                    if ($invsrno == '') {
                        return '
                               <a href="' . route('generate_invoice', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-info" title="Generate Invoice" style=" width: 50px; margin-bottom: 1px;
margin-top:0px;">
<svg fill="#ffffff" width="22px" height="22px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M18,2H6A2,2,0,0,0,4,4V22l3-3,2,3,3-3,3,3,2-3,3,3V4A2,2,0,0,0,18,2ZM12,16H8a1,1,0,0,1,0-2h4a1,1,0,0,1,0,2Zm0-4H8a1,1,0,0,1,0-2h4a1,1,0,0,1,0,2Zm4,4H15a1,1,0,0,1,0-2h1a1,1,0,0,1,0,2Zm0-4H15a1,1,0,0,1,0-2h1a1,1,0,0,1,0,2Zm0-5H8A1,1,0,0,1,8,5h8a1,1,0,0,1,0,2Z"></path></g></svg>
</a>
                       ';
                    } else {
                        return '-';
                    }
                }else{
                    return '-';
                }
                })
		->addColumn('actions', function ($datas) {
 		if ($datas->entry_status == 'D') {
		  return '<b style="color:#880009 !important;">DELETED</b>';
                }else if ($datas->entry_status != 'E') {
                        $invoicesrno = $datas->invoice_sr_no;
                        $accounting_invoiceid = $datas->accounting_invoice_id;
                        if($invoicesrno == '') {
				return '
					<a href="' . route('edit_quotation', $accounting_invoiceid) . '" class="btn btn-success" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" 
class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 
.316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 
0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg></a><br>
				<a href="javascript: void(0)" id="deleteCustomerButton" onclick="myFunction('.$accounting_invoiceid.')" class="btn btn-danger" title="Delete" style="margin-top:2px; margin-bottom:2px;"><svg xmlns="http://www.w3.org/2000/svg" 
width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5
0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8
4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                     </svg></a>
                            	';
			} else {
                        return '
				<a href="javascript: void(0)" id="deleteCustomerButton" onclick="myFunction('.$accounting_invoiceid.')" class="btn btn-danger" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" 
width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 
0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8
4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                     </svg></a>
	                ';
			}
        }else{
            return '-';
        }
                })
                ->rawColumns(array("download", "action", "raise_invoice", "payment_attach", "actions"))
                ->make(true);
        }


        return view('summary_list');
    }
}
