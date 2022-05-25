<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\WebApiController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AppraisalTypeController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\MarketingController;

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
Route::get( '/locale/{locale}', LocalizationController::class )->name( 'locale.change' );
Route::group( [ 'middleware' => [ 'auth:sanctum' ] ], function () {
	 //Dashboard
	 Route::get( 'dashboard', [ DashboardController::class, 'index' ] )->name( 'dashboard' );
	 //User Controller
	 Route::get( 'users',
		 [ UserController::class, 'index' ] )->middleware( 'role_permission:view.user' )->name( 'users.index' );
	 Route::get( 'users/create',
		 [ UserController::class, 'create' ] )->middleware( 'role_permission:create.user' )->name( 'users.create' );
	 Route::post( 'users',
		 [ UserController::class, 'store' ] )->middleware( 'role_permission:create.user' )->name( 'users.store' );
	 Route::post( 'user-status-change/{id}', [
		 UserController::class,
		 'statusChange',
	 ] )->middleware( 'role_permission:update.user' )->name( 'users.status.change' );
	 Route::get( 'users/{id}/edit',
		 [ UserController::class, 'edit' ] )->middleware( 'role_permission:update.user' )->name( 'users.edit' );
	 Route::put( 'users/{id}',
		 [ UserController::class, 'update' ] )->middleware( 'role_permission:update.user' )->name( 'users.update' );
	 Route::post( 'users/{id}',
		 [ UserController::class, 'destroy' ] )->middleware( 'role_permission:delete.user' )->name( 'users.destroy' );
	 Route::get( 'profiles', [ UserController::class, 'getProfile' ] )->name( 'profile' );
	 Route::post( 'profiles', [ UserController::class, 'updateProfile' ] )->name( 'profile.update' );
	 //Role Controller
	 Route::get( 'roles',
		 [ RoleController::class, 'index' ] )->middleware( 'role_permission:view.role' )->name( 'roles.index' );
	 Route::get( 'roles/create',
		 [ RoleController::class, 'create' ] )->middleware( 'role_permission:create.role' )->name( 'roles.create' );
	 Route::post( 'roles',
		 [ RoleController::class, 'store' ] )->middleware( 'role_permission:create.role' )->name( 'roles.store' );
	 Route::get( 'roles/{id}/edit',
		 [ RoleController::class, 'edit' ] )->middleware( 'role_permission:update.role' )->name( 'roles.edit' );
	 Route::put( 'roles/{id}',
		 [ RoleController::class, 'update' ] )->middleware( 'role_permission:update.role' )->name( 'roles.update' );
	 Route::post( 'roles/{id}',
		 [ RoleController::class, 'destroy' ] )->middleware( 'role_permission:delete.role' )->name( 'roles.destroy' );
	 //Client Controller
	 Route::get( 'clients',
		 [ ClientController::class, 'index' ] )->middleware( 'role_permission:view.client' )->name( 'clients.index' );
	 Route::get( 'clients/create',
		 [ ClientController::class, 'create' ] )->middleware( 'role_permission:create.client' )->name( 'clients.create' );
	 Route::post( 'clients',
		 [ ClientController::class, 'store' ] )->middleware( 'role_permission:create.client' )->name( 'clients.store' );
	 Route::get( 'clients/{id}',
		 [ ClientController::class, 'show' ] )->middleware( 'role_permission:view.client' )->name( 'clients.show' );
	 Route::get( 'clients/{id}/edit',
		 [ ClientController::class, 'edit' ] )->middleware( 'role_permission:update.client' )->name( 'clients.edit' );
	 Route::put( 'clients/{id}',
		 [ ClientController::class, 'update' ] )->middleware( 'role_permission:update.client' )->name( 'clients.update' );
	 Route::delete( 'clients/{id}',
		 [ ClientController::class, 'destroy' ] )->middleware( 'role_permission:delete.client' )->name( 'clients.destroy' );
	 Route::get( 'get-clients/{type}', [ ClientController::class, 'getClientsByType' ] );
	 //order
	 Route::get( 'orders',
		 [ OrderController::class, 'index' ] )->middleware( 'role_permission:view.order' )->name( 'orders.index' );
	 Route::get( 'orders/create',
		 [ OrderController::class, 'create' ] )->middleware( 'role_permission:create.order' )->name( 'orders.create' );
	 Route::post( 'orders',
		 [ OrderController::class, 'store' ] )->middleware( 'role_permission:create.order' )->name( 'orders.store' );
	 Route::get( 'orders/{id}',
		 [ OrderController::class, 'show' ] )->middleware( 'role_permission:view.order' )->name( 'orders.show' );
	 Route::get( 'orders/{id}/edit',
		 [ OrderController::class, 'edit' ] )->middleware( 'role_permission:update.order' )->name( 'orders.edit' );
	 Route::put( 'orders/{id}',
		 [ OrderController::class, 'update' ] )->middleware( 'role_permission:update.order' )->name( 'orders.update' );
	 Route::delete( 'orders/{id}',
		 [ OrderController::class, 'destroy' ] )->middleware( 'role_permission:delete.order' )->name( 'orders.destroy' );

     //order details
    Route::get('save-order-data',[OrderController::class,'saveOrderData']);

    Route::get('/get-basic-info/{id}',[OrderController::class,'getBasicInfo'])->middleware('role_permission:view.order');
    Route::get('/get-appraisal-info/{id}',[OrderController::class,'getAppraisalInfo'])->middleware('role_permission:view.order');
    Route::get('/get-borrower-info/{id}',[OrderController::class,'getBorrowerInfo'])->middleware('role_permission:view.order');
    Route::get('/get-contact-info/{id}',[OrderController::class,'getContactInfo'])->middleware('role_permission:view.order');
    Route::get('/get-clients-info/{id}',[OrderController::class,'getClientsInfo']);
    Route::get('/get-activity-log/{id}',[OrderController::class,'getActivityLog']);


    Route::post('/update-basic-info/{id}',[OrderController::class,'updateBasicInfo'])->middleware('role_permission:update.order');
    Route::post('/update-appraisal-info/{id}',[OrderController::class,'updateAppraisalInfo'])->middleware('role_permission:update.order');
    Route::post('/update-borrower-info/{id}',[OrderController::class,'updateBorrowerInfo'])->middleware('role_permission:update.order');
    Route::post('/update-contact-info/{id}',[OrderController::class,'updateContactInfo'])->middleware('role_permission:update.order');

    //Appraisal Type
	 Route::get( 'appraisal-types',
		 [ AppraisalTypeController::class, 'index' ] )->middleware( 'role_permission:view.appraisaltype' )->name( 'appraisal-types.index' );
	 Route::get( 'appraisal-types/create',
		 [ AppraisalTypeController::class, 'create' ] )->middleware( 'role_permission:create.appraisaltype' )->name( 'appraisal-types.create' );
	 Route::post( 'appraisal-types',
		 [ AppraisalTypeController::class, 'store' ] )->middleware( 'role_permission:create.appraisaltype' )->name( 'appraisal-types.store' );
	 Route::get( 'appraisal-types/{id}',
		 [ AppraisalTypeController::class, 'show' ] )->middleware( 'role_permission:view.appraisaltype' )->name( 'appraisal-types.show' );
	 Route::get( 'appraisal-types/{id}/edit',
		 [ AppraisalTypeController::class, 'edit' ] )->middleware( 'role_permission:update.appraisaltype' )->name( 'appraisal-types.edit' );
	 Route::put( 'appraisal-types/{id}',
		 [ AppraisalTypeController::class, 'update' ] )->middleware( 'role_permission:update.appraisaltype' )->name( 'appraisal-types.update' );
	 Route::post( 'appraisal-types/{id}',
		 [ AppraisalTypeController::class, 'destroy' ] )->middleware( 'role_permission:delete.appraisaltype' )->name( 'appraisal-types.destroy' );
	 //Loan Type
	 Route::get( 'loan-types',
		 [ LoanTypeController::class, 'index' ] )->middleware( 'role_permission:view.loantype' )->name( 'loan-types.index' );
	 Route::get( 'loan-types/create',
		 [ LoanTypeController::class, 'create' ] )->middleware( 'role_permission:create.loantype' )->name( 'loan-types.create' );
	 Route::post( 'loan-types',
		 [ LoanTypeController::class, 'store' ] )->middleware( 'role_permission:create.loantype' )->name( 'loan-types.store' );
	 Route::get( 'loan-types/{id}',
		 [ LoanTypeController::class, 'show' ] )->middleware( 'role_permission:view.loantype' )->name( 'loan-types.show' );
	 Route::get( 'loan-types/{id}/edit',
		 [ LoanTypeController::class, 'edit' ] )->middleware( 'role_permission:update.loantype' )->name( 'loan-types.edit' );
	 Route::put( 'loan-types/{id}',
		 [ LoanTypeController::class, 'update' ] )->middleware( 'role_permission:update.loantype' )->name( 'loan-types.update' );
	 Route::post( 'loan-types/{id}',
		 [ LoanTypeController::class, 'destroy' ] )->middleware( 'role_permission:delete.loantype' )->name( 'loan-types.destroy' );

     //Marketing
    Route::get( 'marketing',
        [ MarketingController::class, 'index' ] )->middleware( 'role_permission:view.marketing' )->name( 'marketing.index' );
} );
Auth::routes();

Route::any('/import-client',[ClientController::class,'importClient'])->name('import-client');
Route::redirect( '/', '/login' );
Route::view( '/404', 'dashboard.error' );
Route::view( '/order', 'dashboard.order' );
Route::view( '/order-details', 'dashboard.order-details' )->name( 'order.details' );
Route::view( '/order-add', 'dashboard.order-add' )->name( 'order.add' );
Route::view( '/order-add-step2', 'dashboard.order-add-step2' )->name( 'order.add-step2' );
Route::get( 'get/icons', [IconController::class, 'index'])->name('get.icon');
Route::get( 'email/verify/{id}/{hash}', [ VerificationController::class, 'verify' ] )->name( 'verification.verify' );
Route::get( 'accept-new-user/{code}', [ UserController::class, 'acceptInviteUser' ] )->name( 'accept.new.user' );
Route::post( 'invite-user-update/{id}',
	[ UserController::class, 'inviteUserUpdate' ] )->name( 'update.invite.user.profile' );
Route::get('/public-order/{id}',[OrderController::class,'publicOrder'])->name('public.order');
Route::post('/upload-order-files/{id}',[OrderController::class,'uploadOrderFiles'])->name('order.file.upload');
//Route::get( "{slug}", [ WebApiController::class, 'home' ] )->where( 'slug', ".*" );
