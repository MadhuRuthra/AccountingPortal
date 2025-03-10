<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CreatecampaignController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Create_invoiceController;
use App\Http\Controllers\Create_productController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RegistercilentController;
use App\Http\Controllers\SummarylistController;
use App\Http\Controllers\GenerateInvoiceController;
use App\Http\Controllers\ChangepasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return  View('auth.login');
});
Route::get('file-export', [Create_invoiceController::class, 'fileExport'])->name('file-export');
Route::match(['get', 'post'], 'file-import', [Create_invoiceController::class, 'fileImport'])->name('file-import');

Route::match(['get', 'post'], 'edit_quotation', [Create_invoiceController::class, 'store'])->name('edit_quotation');

Route::post('/invoice', [Create_invoiceController::class, 'saveInvoice'])->name('invoice');
// Route::post('/payment', [Create_invoiceController::class, 'savePayment'])->name('payment');
Route::match(['get', 'post'],'/payment', [Create_invoiceController::class, 'savePayment'])->name('payment');

Route::post('/product', [ProductController::class, 'addProduct'])->name('product');

Route::get('/create_product', [Create_productController::class, 'createProduct'])->name('create_product');
Route::get('/create_invoice', [Create_invoiceController::class, 'fileImport'])->name('create_invoice');

Route::get('/invoice', [InvoiceController::class, 'invoice'])->name('invoice');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/invoice1', [DashboardController::class, 'invoice_1'])->name('invoice1');

Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::get('/document', [DocumentController::class, 'document'])->name('document');
Route::get('/customer', [CustomerController::class, 'customer'])->name('customer');
Route::match(['get', 'post'], '/editcilent', [Create_invoiceController::class,'editClient'])->name('editcilent');
// Route::match(['get', 'post'], '/customer', [CustomerController::class, 'customer_delete'])->name('customer');

Route::match(['get', 'post'], '/customer_del', [Create_invoiceController::class,'customer_delete'])->name('customer_del');
Route::match(['get', 'post'], '/quotation_del', [Create_invoiceController::class,'quotation_delete'])->name('quotation_del');

Route::match(['get', 'post'], '/customer/delete', [Create_invoiceController::class,'customer_delete'])->name('/customer/delete');

Route::get('/create_invoice', [Create_invoiceController::class, 'create_invoice'])->name('create_invoice');
Route::get('/cancel', [Create_invoiceController::class, 'cancel'])->name('cancel');
  

Route::get('/quotation_pdf/{accounting_invoice_id}', [InvoiceController::class, 'quotationPDF'])->name('quotation_pdf');
Route::get('/invoice_pdf/{accounting_invoice_id}', [InvoiceController::class, 'invoicePDF'])->name('invoice_pdf');

Route::post('/registercilent', [RegistercilentController::class,'registerCilent'])->name('registercilent');

Route::get('/registercilent', [RegistercilentController::class,'registerCilent'])->name('registercilent');

//Route::match(['get', 'post'], '/filing-upload', [Create_invoiceController::class, 'filing_upload'])->name('filing-upload');

Route::post('/filing', [Create_invoiceController::class, 'filingStatus'])->name('filing');

Route::get('/summary_list', [SummarylistController::class, 'summary'])->name('summary_list');

Route::match(['get', 'post'], '/ajax_generate_invoice/{quotation_no}', [GenerateInvoiceController::class, 'generateInvoice'])->name('ajax_generate_invoice');

Route::post('fetch-states', [RegistercilentController::class, 'fetchState'])->name('fetch-states');

Route::post('fetch-states1', [RegistercilentController::class, 'fetchState1'])->name('fetch-states1');

Route::post('fetch-cities', [RegistercilentController::class, 'fetchCity'])->name('fetch-cities');

Route::match(['get', 'post'], '/generate_invoice', [GenerateInvoiceController::class, 'generatingInvoice'])->name('generate_invoice');


Route::match(['get', 'post'],'/form_generate_invoice', [GenerateInvoiceController::class, 'invoiceform'])->name('form_generate_invoice');
Route::post('/filing-upload', [Create_invoiceController::class, 'filing_upload'])->name('filing-upload');

Route::post('/filing-upload_1', [Create_invoiceController::class, 'filing_upload_1'])->name('filing-upload_1');

Route::post('/summary_payment', [Create_invoiceController::class, 'savePayment'])->name('summary_payment');


Route::get('/changepassword', [ChangepasswordController::class, 'changePassword'])->name('changepassword');
Route::post('/changepassword', [ChangepasswordController::class, 'changePasswordSave'])->name('changepassword');


Auth::routes([
  'register' => false, // Register Routes...
  'reset' => false, // Reset Password Routes...
  'verify' => false, // Email Verification Routes...
]);
