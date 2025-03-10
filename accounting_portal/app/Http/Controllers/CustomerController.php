<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Company_master;
use DB;

class CustomerController extends Controller
{
    public function customer(Request $request) // Registered Clients list function
    {
        // Admin and Sales team only access this page
        if (Auth::id() == '') {
            return redirect()->route('login');
        }
        if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
            return redirect()->route('home');
        }

        // Filtered company_masters data display in data table 
        $data = DB::table('company_masters as cm')
            ->join('user_masters as um', 'cm.user_master_id', '=', 'um.user_master_id')
            ->where('company_status', '<>', 'N')
            ->select('cm.*', 'um.user_master_title', DB::raw("CONCAT(cm.company_email, '\n', cm.company_phone) AS 
ph_email"), DB::raw("CONCAT(COALESCE(cm.company_address,''),'\n',COALESCE(cm.company_address_2,''),'\n',COALESCE(cm.company_address_3,''),'\n',COALESCE(cm.company_address_4,''),'\n',COALESCE(cm.company_location,''),'\n',COALESCE(cm.company_state,''),'\n', COALESCE(cm.company_pincode,'')) AS user_address"), DB::raw("CASE WHEN contact_person_secondary IS NULL THEN '-' ELSE contact_person_secondary END AS contact_1"), DB::raw("CASE WHEN contact_no_secondary IS NULL THEN '-' ELSE contact_no_secondary END AS contact_2"), DB::raw("CASE WHEN company_email_secondary IS NULL THEN '-' ELSE company_email_secondary END AS contact_3"));

        if ($request->ajax()) { // using ajax to get values for Search bar and date filter

            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if ($request->input('search.value') != "") { // search bar condition
    
                        $instance->where(function ($w) use ($request) {
                            // column values get in query for search filter
                            $w->where('company_name', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('gst_no', 'like', "%{$request->input('search.value')}%")
				->orWhere('company_contact_user', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_phone', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_email', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('submitted_name', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_address', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_address_2', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_address_3', 'like', "%{$request->input('search.value')}%")
				->orWhere('company_address_4', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_location', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_state', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('company_pincode', 'like', "%{$request->input('search.value')}%");
                        });

                    }
                    // Date filter function for From date and To date
                    if (empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // Two dates are empty if the condition is display all data
                        $instance = Company_master::get();
                    } elseif (!empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 
    
                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {

                            $w->whereDate(DB::raw('DATE(company_entry_date)'), '=', $detail_end_date);
                        })->get()->all();

                    } elseif (empty($request->get('detail_to_date')) && !empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 
    
                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(company_entry_date)'), '=', $detail_from_date);
                        })->get()->all();

                    } else {
                        // if Double output given. else part provide From to To date filtered data
                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(company_entry_date)'), '>=', $detail_from_date)
                                ->whereDate(DB::raw('DATE(company_entry_date)'), '<=', $detail_end_date);
                        })->get()->all();
                    }

                })
                // Create Quotation Choose ratio button for selected client user_id 
                ->addColumn('action', function ($datas) {
                    return '

                        <a href="' . route('create_invoice', $datas->user_id) . '" title="Generate Quotation" style="width: 50px; margin-top: 1px; text-align: center; color: #000; text-decoration: none;">
				<input type="radio" name="rdo_gen_quotation" id="rdo_gen_quotation" value="' . route('create_invoice', $datas->user_id) . '"  style="pointer-events:none; color: #000; text-decoration: none;"> Choose
			</a>
           
                        ';

                })
                // Edit and Delete button for selected client user_id 
                ->addColumn('add_edit', function ($datas) {
                    return '

                    <a href="' . route('create_invoice', $datas->user_id) . '" title="Generate Quotation" style="width: 49px; margin-top: 1px; text-align: center; color: white; text-decoration: none;" class="btn btn-primary" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
                    </svg></a><br>


                    <a href="' . route('editcilent', $datas->user_id) . '" class="btn btn-success" title="Edit" style="margin-top:2px; margin-bottom:2px;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg></a><br>

                     <a href="#" id="deleteCustomerButton" onclick="myFunction(' . $datas->user_id . ')" class="btn btn-danger" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                     </svg></a>

                    ';
                })
                ->rawColumns(array("action", "add_edit")) // used to display two columns with button
                ->make(true);
        }

        return view('customer');
    }

}
