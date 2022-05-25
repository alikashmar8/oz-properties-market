<?php

use App\Models\Company;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
use App\Mail\NewPropertyMail;

Route::get('/em', function () {
    $id = 1;
    $property = \App\Models\Property::findOrFail($id);
    $property->images = \App\Models\PropertyImage::where('propertyId', $property->id)->get();
    return view('Pdf.brochure' , compact('property'));
});


Route::get('/terms_and_conditions', function () {
    return view('terms');
});
Route::get('/privacy_policy', function () {
    return view('privacy');
});

Route::get('/tips', function () {
    return view('tips');
});

Route::get('/evaluate', function () {
    return view('evaluate');
});


Route::get('/insurance', function () {
    return view('insurance');
});
Route::get('/findAgents', function (Request $request) {
    if (isset($request->name)) {
        $searched = $request->name;
        $searchBy = $request->searchBy;
        $results = [];
        if ($searchBy == 'name') {
            $results = User::where('role', '=', 1)->where('name', 'like', '%' . $searched . '%')->get();
            foreach ($results as $user) {
                $user->company = Company::where('AgentId', $user->id)->first();
            }
        }
        if ($searchBy == 'companyName') {
            $companies = Company::where('name', 'like', '%' . $searched . '%')->get();
            foreach ($companies as $company) {
                $user = User::findOrFail($company->AgentId);
                $user->company = $company;
                $results[$user->id] = $user;
            }
        }

//        if ($type == 'location'){
//
//          }
        $type = $request->type;

    } else {
        $searched = '';
        $results = User::where('role', '=', 1)->get();
        foreach ($results as $user) {
            $user->company = Company::where('AgentId', $user->id)->first();
        }
        $type = 'agents';
    }
    return view('findAgents', compact('searched', 'results', 'type'));
});

//All users route
Route::get('/', '\App\Http\Controllers\PropertiesController@index')->name('index');
Route::get('/properties/buy', '\App\Http\Controllers\PropertiesController@buyIndex');
Route::get('/properties/rent', '\App\Http\Controllers\PropertiesController@rentIndex');
Route::get('/submitEvaluation', '\App\Http\Controllers\EmailsController@submitEvaluationForm');
Route::get('/contactForProperty', '\App\Http\Controllers\EmailsController@contactForProperty');
Route::get('/reportProperty', '\App\Http\Controllers\EmailsController@reportProperty');

//Admin Routes
Route::post('/accept', '\App\Http\Controllers\PropertiesController@accept')->middleware('auth');
Route::get('/acceptProperties', '\App\Http\Controllers\PropertiesController@viewNotAcceptedProperties')->middleware('auth');
Route::get('/acceptedProperties', '\App\Http\Controllers\PropertiesController@allAcceptedProperties')->middleware('auth');
Route::get('/users', '\App\Http\Controllers\UsersController@index')->middleware('auth');
Route::get('/agents', '\App\Http\Controllers\UsersController@agentsIndex')->middleware('auth');

Route::resource('users', '\App\Http\Controllers\UsersController', ['except' => ['index', 'store', 'create', 'show', 'edit', 'destroy']])->middleware(['auth', 'verified']);
Route::get('/users/{id}', '\App\Http\Controllers\UsersController@show')->middleware('auth');
Route::delete('/users/destroy/{id}', '\App\Http\Controllers\UsersController@destroy')->middleware('auth');

Route::post('reset_password', '\App\Http\Controllers\ResetPasswordController@forgetRequest');

//Route::get('/properties/{id}', '\App\Http\Controllers\PropertiesController@edit')->middleware('auth');
Route::get('/properties/myProperties', '\App\Http\Controllers\PropertiesController@myProperties')->middleware(['auth', 'verified']);
Route::resource('properties', '\App\Http\Controllers\PropertiesController', ['except' => ['show']])->middleware(['auth', 'verified']);
Route::get('/properties/{id}', '\App\Http\Controllers\PropertiesController@show');
Route::get('/userShowProperty', '\App\Http\Controllers\PropertiesController@showProperty');
Route::get('/userHideProperty', '\App\Http\Controllers\PropertiesController@hideProperty');
Route::get('/search-agents', '\App\Http\Controllers\SearchController@searchAgent');
Route::get('/search-properties', '\App\Http\Controllers\SearchController@searchProperties');
//sold
Route::post('soldProperty','\App\Http\Controllers\PropertiesController@soldProperty')->name('soldProperty');


//Auth::routes(['verify' => true, 'password.email'=> false]);
/////////////////////AUTH ROUTES//////////////////
Route::get('login', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', '\App\Http\Controllers\Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', '\App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', '\App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password (added in v6.2)
Route::get('password/confirm', '\App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', '\App\Http\Controllers\Auth\ConfirmPasswordController@confirm');

// Email Verification Routes...
Route::get('email/verify', '\App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', '\App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify'); // v6.x
Route::get('email/resend', '\App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

//////////////////END AUTH ROUTES//////////////


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Commercial pages
//Route::get('/commercial', '\App\Http\Controllers\commercialController@index');
Route::get('/commercial', [App\Http\Controllers\commercialController::class, 'index']);
Route::get('/createCommercial', [App\Http\Controllers\commercialController::class, 'create'])->middleware(['auth', 'verified']);

Route::post('storeCommercial', '\App\Http\Controllers\commercialController@store')->name('storeCommercial');
Route::get('/commercial/{id}', '\App\Http\Controllers\commercialController@show');
Route::get('/myCommercial', [App\Http\Controllers\commercialController::class, 'myCommercial']);
Route::get('/commercial/{id}/edit', '\App\Http\Controllers\commercialController@edit');
Route::post('updateCommercial', '\App\Http\Controllers\commercialController@update')->name('updateCommercial');

Route::get('/search-commercials', '\App\Http\Controllers\SearchController@searchCommercials');

//Admin Commercials

Route::get('/acceptCommercials', '\App\Http\Controllers\commercialController@viewNotAccepted')->middleware('auth');
Route::post('/acceptCom', '\App\Http\Controllers\commercialController@accept')->middleware('auth');
Route::delete('/destroyCom/{id}', '\App\Http\Controllers\commercialController@destroy')->middleware('auth');
Route::get('/allCommercials', '\App\Http\Controllers\commercialController@allCommercials')->middleware('auth');

Route::get('/histories/properties', '\App\Http\Controllers\HistoriesController@propertiesIndex');
Route::get('/histories/properties/{id}', '\App\Http\Controllers\HistoriesController@propertyShow');


Route::get('/histories/commercials', '\App\Http\Controllers\HistoriesController@commercialsIndex');
Route::get('/histories/commercials/{id}', '\App\Http\Controllers\HistoriesController@commercialShow');


Route::get('/histories/users', '\App\Http\Controllers\HistoriesController@usersIndex');
Route::get('/histories/users/{id}', '\App\Http\Controllers\HistoriesController@userShow');

Route::resource('/histories', '\App\Http\Controllers\HistoriesController')->middleware('auth');


Route::get('/userShowCommercial', '\App\Http\Controllers\commercialController@showCommercial');
Route::get('/userHideCommercial', '\App\Http\Controllers\commercialController@hideCommercial');

//packages
Route::get('/packages', function () {
    return view('Packages.packages');
});
Route::get('/pricing', function () {
    return view('Packages.pricing');
});
Route::get('/order/{id}', function () {
    return view('Packages.order');
});
Route::get('/order/{id}/{amount}', '\App\Http\Controllers\PropertiesController@package')->middleware('auth');
Route::post('storePayment', '\App\Http\Controllers\PaymentController@store')->name('storePayment');

//Route::get('/completePayment/{id}', '\App\Http\Controllers\PropertiesController@complete')->middleware('auth');

//Route::get('/upgrade/{id}', '\App\Http\Controllers\PropertiesController@upgradePackage')->middleware('auth');
Route::post('upgradePackage', '\App\Http\Controllers\PropertiesController@upgradePackage')->name('upgradePackage');
Route::post('upgradePackageCommercial', '\App\Http\Controllers\commercialController@upgradePackageCom')->name('upgradePackageCommercial');


Route::get('/userPayments', '\App\Http\Controllers\PaymentController@index')->middleware(['auth', 'verified']);
Route::get('/adminPayments', '\App\Http\Controllers\PaymentController@index')->middleware(['auth', 'verified']);

Route::get('/Stripe/{amount}/{id}', '\App\Http\Controllers\PaymentController@Stripe')->middleware(['auth', 'verified']);
Route::post('checkout','\App\Http\Controllers\PaymentController@afterStripe')->name('checkout-credit-card');
//Route::get('checkout','\App\Http\Controllers\PaymentController@Stripe');


//paypal
/*Route::get('/paypal', function () {
    return view('Packages.paypal');
});
Route::get('payment', '\App\Http\Controllers\PaymentController@index');
Route::post('charge', '\App\Http\Controllers\PaymentController@charge');
Route::get('paymentsuccess', '\App\Http\Controllers\PaymentController@payment_success');
Route::get('paymenterror', '\App\Http\Controllers\PaymentController@payment_error');*/


//invoice
use Barryvdh\DomPDF\Facade as PDF;
Route::get('/invoice', function () {
    $pdf = PDF::loadView('pdf.invoice');

    return $pdf->download('invoice.pdf');
});
Route::get('/invoice/{id}', '\App\Http\Controllers\PaymentController@getInvoice')->middleware(['auth', 'verified']);


Route::get('/brochure/{id}', '\App\Http\Controllers\PropertiesController@brochure') ;
Route::get('/comBrochure/{id}', '\App\Http\Controllers\commercialController@brochure') ;

Route::get('/getPdf', function (Request $request) {
    /*$pdf = 'pdfApp/'.$request->state ;
    return $pdf->download('invoice.pdf');*/
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/pdfApp/".$request->state.".pdf";

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, $request->state.' Pdf Application.pdf' );



})->name('getPdf');




//inspection
Route::post('/setInspection','\App\Http\Controllers\PropertiesController@setInspection')->name('setInspection');

Route::get('/deleteInspection/{id}','\App\Http\Controllers\PropertiesController@deleteInspection')->middleware(['auth', 'verified']);
Route::get('/inspect/{id}','\App\Http\Controllers\PropertiesController@Inspect')->middleware(['auth', 'verified']);



