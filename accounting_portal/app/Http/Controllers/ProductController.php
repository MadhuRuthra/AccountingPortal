<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Product_master;
use DB;

class ProductController extends Controller
{

    public function product(Request $request)
    {
        if (Auth::id() == '') {
            return redirect()->route('login');
        }
        // Admin and Sales team only access this page
        if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
            return redirect()->route('home');
        }
        // Filtered product_masters data display in data table 
        $data = DB::table('product_masters as pm')
            ->select('pm.*', 'pm.product_master_id', DB::raw("CASE WHEN pm.product_master_status = 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END AS product_status"));

        if ($request->ajax()) { // using ajax to get values for Search bar and date filter

            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if ($request->input('search.value') != "") { // search bar condition
    
                        $instance->where(function ($w) use ($request) {
                            // column values get in query for search filter
    
                            $w->where('pm.product_master_name', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('pm.product_master_details', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('pm.product_qty', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('pm.product_rate', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('pm.product_gst', 'like', "%{$request->input('search.value')}%")
                                ->orWhere('pm.product_master_status', 'like', "%{$request->input('search.value')}%");

                        });

                    }
                })
                ->make(true);
        }

        return view('product');
    }


    public function addProduct(Request $request) // Create product function 
    {
        // Create product input values
        $submit_date = date("Y-m-d H:m:s");
        $gst_status = 'Y';
        $product_amount = '0';
        $product_total_amount = '0';

        $product_name = $request->input('product_name');
        $product_details = $request->input('product_details');
        $product_quantity = 1;
        $product_rate = $request->input('product_rate');
        $product_gst = $request->input('product_gst');

        // Get all values in array and insert the values in DB Table
        $data = array(
            'product_master_name' => $product_name,
            'product_master_details' => $product_details,
            'product_master_status' => $gst_status,
            'product_master_entdate' => $submit_date,
            'product_qty' => $product_quantity,
            'product_rate' => $product_rate,
            'product_amount' => $product_amount,
            'product_gst' => $product_gst,
            'product_total_amount' => $product_total_amount,
            'created_at' => $submit_date
        );

        DB::table('product_masters')->insert($data); // Update values in database

        return view('product');
    }


}