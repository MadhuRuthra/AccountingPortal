<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Product_master;
use DB;

class DocumentController extends Controller
{
    public function document(Request $request)
    {
   
        if (Auth::id() == '') {
            return redirect()->route('login'); 
        }
        // Admin and sales team only access this pages 
        if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
            return redirect()->route('home');
        }

        if ($request->ajax()) { // using ajax to get values for Search bar and date filter

            $data = DB::table('document_managers as pm')
                ->select('pm.*');
    
            return Datatables::of($data) // Fitered values display in Datatables
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
 
                    $query->where(function ($w) use ($request) {
                        $w->where('pm.document_details', 'like', "%{$request->input('search.value')}%");
                    });

                })
                // Action column for Download Documents
                ->addColumn('action', function ($datas) {
                    return '
                        <a title="Download Documents" href="storage/app/' . $datas->document_url . '" download class="btn btn-xs btn-success" style="margin-bottom: 1px; width: 50px"> <svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 10px;" width="22" height="22" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg></a>
		    ';
                })

                ->make(true);
        }

        return view('document');
    }

}