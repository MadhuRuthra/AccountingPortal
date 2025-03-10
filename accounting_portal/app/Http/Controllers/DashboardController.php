<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\Accounting_invoice;
use DB;
use PDF;
use App\Models\Company_master;

class DashboardController extends Controller // Dashboard pop up function
{
    public function invoice_1(Request $request)
    {
        if (Auth::id() == '') {
            return redirect()->route('login'); // All users to access this page
        }
        // Filtered company_masters data display in data table 
        $data = DB::table('accounting_invoices as ai')  
	    ->join('company_masters as cm', 'ai.company_id', '=', 'cm.user_id')  
            ->select(
                'ai.*','cm.gst_no', DB::raw("FORMAT(ai.quantity, 2, 'en_IN') AS quantity_format"), DB::raw("FORMAT(ai.rate, 2, 'en_IN') AS rate_format"), DB::raw("FORMAT(ai.sub_total_amount, 2, 'en_IN') AS sub_total_amount_format"), DB::raw("FORMAT(ai.gst_amount, 2, 'en_IN') AS gst_amount_format"), DB::raw("FORMAT(ROUND(ai.total_amount, 0), 2, 'en_IN') AS total_amount_format"), DB::raw("CONCAT(ai.po_details, ',\n', ai.invoice_sr_no) AS po_invoice"), DB::raw("CONCAT('Payment Status: ', CASE WHEN ai.payment_status = 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END, '\nPayment Received: ', CASE WHEN ai.payment_received = 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END) AS payment_details"),
                DB::raw("CASE WHEN ai.received_date IS NULL THEN '-' ELSE ai.received_date END AS received_dates"),
                DB::raw("CASE WHEN ai.invoice_sr_no IS NULL THEN '-' ELSE ai.invoice_sr_no END AS invoice_sr_num"), DB::raw("CASE ai.payment_received
            WHEN 'Y' THEN 'RECEIVED'
            ELSE 
                CASE
			WHEN ai.received_date IS NULL THEN 'INVOICE NOT GENERATED'
	                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 30 THEN '< 30'
	                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 60 THEN '< 60'
	                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 90 THEN '< 90'
	                ELSE '> 90'
                END
            END AS days_diff"
                )
            )
            ->where('payment_received')
            ->whereRaw('DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, "%Y-%m-%d")) > 30');
    	
        if ($request->ajax()) { // using ajax to get values for Search bar and date filter

	// echo "==".$data."==";
            return Datatables::of($data)
                ->addIndexColumn()

                ->filter(function ($instance) use ($request) {

                    if ($request->input('search.value') != "") { // search bar condition

                        $instance->where(function ($w) use ($request) {
                              // column values get in query for search filter
                            $w->whereRaw("received_date like '%{$request->input('search.value')}%' or activity_details like '%{$request->input('search.value')}%' or FORMAT(ai.quantity, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.rate, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.sub_total_amount, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.gst_amount, 2, 'en_IN') like '%{$request->input('search.value')}%' or FORMAT(ai.total_amount, 2, 'en_IN') like '%{$request->input('search.value')}%' or submit_date like '%{$request->input('search.value')}%' or quotation_sr_no like '%{$request->input('search.value')}%' or invoice_sr_no like '%{$request->input('search.value')}%' or CASE
        WHEN ai.payment_received = 'Y' THEN 'RECEIVED'
        ELSE 
            CASE
                WHEN ai.received_date IS NULL THEN 'INVOICE NOT GENERATED'
                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 30 THEN '< 30'
                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 60 THEN '< 60'
                WHEN DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, '%Y-%m-%d')) < 90 THEN '< 90'
                ELSE '> 90'
            END
        END like '%{$request->input('search.value')}%'");

                        });

                    }
                    // Date filter function for From date and To date
                    if (empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // Two dates are empty if the condition is display all data
                        $instance = Accounting_invoice::get();
                    } elseif (!empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {

                            $w->whereDate(DB::raw('DATE(submit_date)'), '=', $detail_end_date);
                        })->get()->all();

                    } elseif (empty($request->get('detail_to_date')) && !empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(submit_date)'), '=', $detail_from_date);
                        })->get()->all();

                    } else { // if Double output given. else part provide From to To date filtered data

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(submit_date)'), '>=', $detail_from_date)
                                ->whereDate(DB::raw('DATE(submit_date)'), '<=', $detail_end_date);
                        })->get()->all();
                    }

                })
                // Download buton for invoice pdf
                ->addColumn('action', function ($datas) {
                    if ($datas->invoice_sr_no == '') { // if invoice not create. This button not display in list 
                        return '-';
                    } else {
                        return '
			<a title="Download Invoice" href="' . route('invoice_pdf', $datas->accounting_invoice_id) . '" class="btn btn-xs btn-success" style=" width: 50px; margin-bottom: 1px;"><svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 10px; " width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5
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
	                  <a href="public/uploads/' . $data->filing_upload . '" download  class="btn btn-xs btn-success" style="width: 172px; margin-bottom: 1px;" title="GST Filed Attachment Download">Download File</a>
                  	';
                        } else {
                            return $filingStatus->filing_upload; // file is empty upload button display on this list
                        }
                    } else { // Other teams access the Gst file attachments
                        $filingStatus = DB::table('accounting_invoices as ai')
                            ->select(DB::raw("CASE WHEN ai.filing_status = 'Y' THEN 'GST FILED' ELSE 'GST NOT FILED' END AS filing_upload"))
                            ->where('ai.accounting_invoice_id', $data->accounting_invoice_id)
                            ->first();

                        if ($data->filing_upload != '') {
                            return '
                  <a title="GST Filed Attachment Download" href="public/uploads/' . $data->filing_upload . '" download  class="btn btn-xs btn-success" style="width: 172px; margin-bottom: 1px;">Download File</a>
                  ';
                        } else {
                            return '
                  <a href="#" title="Upload GST Attachment" class="btn btn-xs btn-danger" style="width: 172px; margin-bottom: 1px;" onclick="filing_upload(' . $data->accounting_invoice_id . ')">Upload File</a>
                ';
                        }

                    }
                })
                ->rawColumns(array("action", "filing_upload")) // used to display two columns with button
                ->make(true);
        }

        return view('invoice');
    }


}
