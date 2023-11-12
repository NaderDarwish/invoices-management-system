<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\Customers_Report;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Auth.login');
});




Auth::routes();
// Auth::routes(['register' => false]);

Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    }
);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource("invoices", InvoicesController::class);
Route::resource("InvoiceAttachments", InvoiceAttachmentsController::class);
Route::get('invoices_report', [Invoices_Report::class, 'index']);
Route::post('Search_invoices', [Invoices_Report::class, 'Search_invoices']);
Route::get('customers_report', [Customers_Report::class, 'index'])->name("customers_report");
Route::post('Search_customers', [Customers_Report::class, 'Search_customers']);
Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);
Route::get('/edit_invoice/{id}', [InvoicesController::class, 'edit']);
Route::get('/Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');
Route::get('Invoice_Paid', [InvoicesController::class, 'Invoice_Paid']);
Route::get('Invoice_UnPaid', [InvoicesController::class, 'Invoice_UnPaid']);
Route::get('Invoice_Partial', [InvoicesController::class, 'Invoice_Partial']);
Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice']);
Route::resource('Archive', InvoiceArchiveController::class);
Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);
Route::post('/delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');
Route::get('/download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);
Route::get('/View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);
Route::resource("sections", SectionController::class);
Route::resource("products", ProductController::class);

Route::get('MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');


Route::get('/{page}', [AdminController::class, 'index']);
