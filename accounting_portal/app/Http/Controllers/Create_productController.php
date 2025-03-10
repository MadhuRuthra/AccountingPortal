<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class Create_productController extends Controller
{
        public function createProduct() // create product function
        {
                // Admin and sales team only access this page
                if (Auth::id() == '') {
                        return redirect()->route('login');
                }
                if (Auth::user()->user_master_id != 1 and Auth::user()->user_master_id != 2) {
                        return redirect()->route('home');
                }

                return view('create_product');
        }
}