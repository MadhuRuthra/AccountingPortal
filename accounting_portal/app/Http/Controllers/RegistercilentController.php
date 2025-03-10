<?php

namespace App\Http\Controllers;

use App\Models\Master_cities;
use App\Models\Master_state;
use Illuminate\Http\Request;
use App\Models\Company_master;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RegistercilentController extends Controller
{
    public function registerCilent(Request $request)
    {
        // Admin and Sales team only access this page
        if (Auth::id() == '') {
            return redirect()->route('login');
        }
        if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
            return redirect()->route('home');
        }

        $submit_date = date("Y-m-d H:i:s");
        $gst_status = 'Y';
        $session_id = '1';
        $user_master_id = '2';

        //store into database
        $name = $request->input('name');
        $c_name =strtoupper($name);
        $email = $request->input('email');

        $gst_no = $request->input('gst_no');
        $hsn_sac_code = '-'; // $request->input('hsn_sac_code');
        $company_type = '-'; // $request->input('company_type');

        $company_contact_user = $request->input('company_contact_user');
        $contact_name =strtoupper($company_contact_user);
        $company_phone = $request->input('company_phone');
        $company_address = $request->input('company_address');
        $com_address =strtoupper($company_address);
        $company_address2 = $request->input('company_address_2');
        $com_address2 =strtoupper($company_address2);
        $company_address3 = $request->input('company_address_3');
        $com_address3 =strtoupper($company_address3);
        $company_address4 = $request->input('company_address_4');
        $com_address4 =strtoupper($company_address4);
        $company_location = $request->input('company_location');
        $company_state = $request->input('company_state');
        $com_state_name =strtoupper($company_state);
        $company_pincode = $request->input('company_pincode');
        $contact_person_secondary = $request->input('contact_person_secondary');
        $contact_no_secondary = $request->input('contact_no_secondary');
        $company_email_secondary = $request->input('company_email_secondary');
        $sumbitted_name = $request->input('sumbitted_name');
        $submit_name=strtoupper($sumbitted_name);
	$location = explode('~~',$company_location); // Split cityname only
	$city = $location[0];
    $city_name =strtoupper($city); // Change Name in Uppercase
        // Get all values in array and insert the values in DB Table
        $data = array(
            'user_master_id' => $user_master_id,
            'company_name' => $c_name,
            'company_email' => $email,
            'gst_no' => $gst_no,
            'hsn_sac_code' => $hsn_sac_code,
            'company_type' => $company_type,
            'company_contact_user' => $contact_name,
            'company_phone' => $company_phone,
            'company_address' => $com_address,
            'company_address_2' => $com_address2,
            'company_address_3' => $com_address3,
            'company_address_4' => $com_address4,
            'company_location' => $city_name,
            'company_status' => $gst_status,
            'company_state' => $com_state_name,
            'company_pincode' => $company_pincode,
            'contact_person_secondary' => $contact_person_secondary,
            'contact_no_secondary' => $contact_no_secondary,
            'company_email_secondary' => $company_email_secondary,
            'submitted_name' => $submit_name,
            'company_entry_date' => $submit_date,
            'created_at' => $submit_date
        );
         // The Register client values are Not null. The values are stored in array 
        if ($name != '' && $email != '' && $gst_no != '' && $company_contact_user != '' && $company_address != '') {
            DB::table('company_masters')->insert($data); // Insert data into the table
            return Redirect::to('registercilent')->with('success', 'Client Registered Successfully');
        }
        return view('registercilent');
    }


    public function index()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('dropdown', $data);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchState(Request $request) // Fetch states for Register Client select state and city
    {
        $data['states'] = Master_state::where("id", $request->state_id)
            ->get(["name", "id"]);

        return response()->json($data);

    }

    public function fetchState1(Request $request) // Fetch states for Edit Client select state and city
    {
        $data['states'] = Master_state::join('master_cities', 'master_states.id', '=', 'master_cities.state_id')
            ->where('master_cities.name', 'like', '%' . $request->name . '%')
            ->select('master_states.name', 'master_states.id')
            ->get();

        return response()->json($data);

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchCity(Request $request) // Fetch city for select state and city
    {
        $data['cities'] = Master_cities::where("state_id", $request->state_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }


}
