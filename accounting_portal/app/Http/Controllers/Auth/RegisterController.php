<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Company_master;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
	    'gst_no' => ['required'],
            'hsn_sac_code' => ['required'],
            'company_type' => ['required'],
            'company_contact_user' => ['required'],
            'company_phone' => ['required'],
            'company_address' => ['required'],
            'company_location' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /* $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

	$company = Company_master::create([
            'user_master_id' => '2',
            'company_name' => $data['name'],
            'company_email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gst_no' => $data['gst_no'],
            'hsn_sac_code' => $data['hsn_sac_code'],
            'company_type' => $data['company_type'],
            'company_contact_user' => $data['company_contact_user'],
            'company_phone' => $data['company_phone'],
            'company_address' => $data['company_address'],
            'company_location' => $data['company_location'],
            'company_status' => 'Y',

        ]); */
		 return $user;	
    }
}
