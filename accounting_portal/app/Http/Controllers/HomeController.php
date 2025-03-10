<?php

namespace App\Http\Controllers;

use App\Models\Accounting_invoice;
use Illuminate\Http\Request;
// use App\Models\cdr;
use Illuminate\Support\Carbon;
use DataTables;
use DB;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;
use Session;

class HomeController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::id() == '') {
      return redirect()->route('login'); 
    }
     // Get data from database using queries
    $data = DB::table('accounting_invoices as ai')
	->join('company_masters as cm', 'ai.company_id', '=', 'cm.user_id')  
      ->select(
        'ai.*','cm.gst_no',
        DB::raw("FORMAT(ai.quantity, 2, 'en_IN') AS quantity_format"),
        DB::raw("FORMAT(ai.rate, 2, 'en_IN') AS rate_format"),
        DB::raw("FORMAT(ai.sub_total_amount, 2, 'en_IN') AS sub_total_amount_format"),
        DB::raw("FORMAT(ai.gst_amount, 2, 'en_IN') AS gst_amount_format"),
        DB::raw("FORMAT(ai.total_amount, 2, 'en_IN') AS total_amount_format"),
        DB::raw("CONCAT(ai.po_details, ',\n', ai.invoice_sr_no) AS po_invoice"),
        DB::raw("CONCAT('Payment Status: ', CASE WHEN ai.payment_status = 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END, '\nPayment Received: ', CASE WHEN ai.payment_received = 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END) AS payment_details"),
        DB::raw("CASE WHEN ai.received_date IS NULL THEN '-' ELSE ai.received_date END AS received_dates"),
        DB::raw("CASE WHEN ai.invoice_sr_no IS NULL THEN '-' ELSE ai.invoice_sr_no END AS invoice_sr_num")
      )
      ->where('DATEDIFF(CURRENT_DATE(), DATE_FORMAT(received_date, "%Y-%m-%d"))', '>', '2');

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
          } else {  // if Double output given. else part provide From to To date filtered data
            $detail_from_date = $request->get('detail_from_date');
            $detail_end_date = $request->get('detail_to_date');

            $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
              $w->whereDate(DB::raw('DATE(submit_date)'), '>=', $detail_from_date)
                ->whereDate(DB::raw('DATE(submit_date)'), '<=', $detail_end_date);
            })->get()->all();
          }
        })
        ->make(true);
    }

    // return view('home', (['data' => $data]));
	return view('home', ['data' => $data]);
  }

  public function callfile()
  {
    return view('file-import');
  }

}
