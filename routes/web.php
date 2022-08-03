<?php

use App\Events\Notify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IconController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\Api\WebApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AppraisalTypeController;
use App\Http\Controllers\OrderWorkflowController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\CallLogController;
use App\Http\Controllers\PusherNotificationController;
use App\Http\Controllers\NotificationController;

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

Route::get('daily-report-template', function () {
    return view('emails.report');
});
Route::get('/locale/{locale}', LocalizationController::class)->name('locale.change');
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('user-dashboard', [DashboardController::class, 'userIndex'])->name('user.dashboard');
    //User Controller
    Route::get(
        'users',
        [UserController::class, 'index']
    )->middleware('role_permission:view.user')->name('users.index');
    Route::get(
        'users/create',
        [UserController::class, 'create']
    )->middleware('role_permission:create.user')->name('users.create');
    Route::post(
        'users',
        [UserController::class, 'store']
    )->middleware('role_permission:create.user')->name('users.store');
    Route::post('user-status-change/{id}', [
        UserController::class,
        'statusChange',
    ])->middleware('role_permission:update.user')->name('users.status.change');
    Route::get(
        'users/{id}/edit',
        [UserController::class, 'edit']
    )->middleware('role_permission:update.user')->name('users.edit');
    Route::put(
        'users/{id}',
        [UserController::class, 'update']
    )->middleware('role_permission:update.user')->name('users.update');
    Route::post(
        'users/{id}',
        [UserController::class, 'destroy']
    )->middleware('role_permission:delete.user')->name('users.destroy');
    Route::get('profiles', [UserController::class, 'getProfile'])->name('profile');
    Route::post('profiles', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('update-color/{id}', [UserController::class, 'updateColor']);
    //Role Controller
    Route::get(
        'roles',
        [RoleController::class, 'index']
    )->middleware('role_permission:view.role')->name('roles.index');
    Route::get(
        'roles/create',
        [RoleController::class, 'create']
    )->middleware('role_permission:create.role')->name('roles.create');
    Route::post(
        'roles',
        [RoleController::class, 'store']
    )->middleware('role_permission:create.role')->name('roles.store');
    Route::get(
        'roles/{id}/edit',
        [RoleController::class, 'edit']
    )->middleware('role_permission:update.role')->name('roles.edit');
    Route::put(
        'roles/{id}',
        [RoleController::class, 'update']
    )->middleware('role_permission:update.role')->name('roles.update');
    Route::post(
        'roles/{id}',
        [RoleController::class, 'destroy']
    )->middleware('role_permission:delete.role')->name('roles.destroy');
    //Client Controller
    Route::get(
        'clients',
        [ClientController::class, 'index']
    )->middleware('role_permission:view.client')->name('clients.index');
    Route::get(
        'clients/create',
        [ClientController::class, 'create']
    )->middleware('role_permission:create.client')->name('clients.create');
    Route::post(
        'clients',
        [ClientController::class, 'store']
    )->middleware('role_permission:create.client')->name('clients.store');
    Route::get(
        'clients/{id}',
        [ClientController::class, 'show']
    )->middleware('role_permission:view.client')->name('clients.show');
    Route::get(
        'clients/{id}/edit',
        [ClientController::class, 'edit']
    )->middleware('role_permission:update.client')->name('clients.edit');
    Route::put(
        'clients/{id}',
        [ClientController::class, 'update']
    )->middleware('role_permission:update.client')->name('clients.update');
    Route::delete(
        'clients/{id}',
        [ClientController::class, 'destroy']
    )->middleware('role_permission:delete.client')->name('clients.destroy');
    Route::get('get-clients/{type}', [ClientController::class, 'getClientsByType']);
    //order
    Route::get(
        'orders',
        [OrderController::class, 'index']
    )->middleware('role_permission:view.order')->name('orders.index');
    Route::get(
        'orders/create',
        [OrderController::class, 'create']
    )->middleware('role_permission:create.order')->name('orders.create');
    Route::post(
        'orders',
        [OrderController::class, 'store']
    )->middleware('role_permission:create.order')->name('orders.store');
    Route::get(
        'orders/{id}',
        [OrderController::class, 'show']
    )->middleware('role_permission:view.order')->name('orders.show');
    Route::get(
        'orders/{id}/edit',
        [OrderController::class, 'edit']
    )->middleware('role_permission:update.order')->name('orders.edit');
    Route::put(
        'orders/{id}',
        [OrderController::class, 'update']
    )->middleware('role_permission:update.order')->name('orders.update');
    Route::delete(
        'orders/{id}',
        [OrderController::class, 'destroy']
    )->middleware('role_permission:delete.order')->name('orders.destroy');

    Route::post(
        'order/update/{type}',
        [OrderController::class, 'orderUpdate']
    )->middleware('role_permission:update.order')->name('orders.update.single');

    Route::post('search/order', [OrderController::class, 'searchOrderData'])->middleware('role_permission:orders.index');
    Route::post('filter-list/order', [OrderController::class, 'filterOrderData'])->middleware('role_permission:orders.index');
    Route::post('api/get/same/orders/by/street', [OrderApiController::class, 'getSameData']);

    //order details
    Route::post('update-order-status', [OrderController::class, 'updateOrderStatus']);

    //call log
    Route::get('call-log/{order_id}', [CallLogController::class, 'index'])->middleware('role_permission:view.order')->name('call.log');
    Route::post('call-log/{order_id}', [CallLogController::class, 'store'])->middleware('role_permission:view.order')->name('call.log.store');
    Route::post('call-log-update/{order_id}', [CallLogController::class, 'update'])->middleware('role_permission:view.order')->name('call.log.store');

    //tickets
    Route::get('issues/{order_id}', [TicketController::class, 'index'])->middleware('role_permission:view.order')->name('call.log');
    Route::post('issue/{order_id}', [TicketController::class, 'store'])->middleware('role_permission:view.order')->name('call.log.store');
    Route::post('update-issue/{id}', [TicketController::class, 'update'])->middleware('role_permission:view.order')->name('call.log.store');
    Route::get('get-tickets/{type}', [TicketController::class, 'getTicketByType']);

    //    Route::get('/get-basic-info/{id}',[OrderController::class,'getBasicInfo'])->middleware('role_permission:view.order');
    //    Route::get('/get-appraisal-info/{id}',[OrderController::class,'getAppraisalInfo'])->middleware('role_permission:view.order');
    //    Route::get('/get-borrower-info/{id}',[OrderController::class,'getBorrowerInfo'])->middleware('role_permission:view.order');
    //    Route::get('/get-contact-info/{id}',[OrderController::class,'getContactInfo'])->middleware('role_permission:view.order');
    //    Route::get('/get-clients-info/{id}',[OrderController::class,'getClientsInfo']);
    //    Route::get('/get-activity-log/{id}',[OrderController::class,'getActivityLog']);


    Route::post('/update-basic-info/{id}', [OrderController::class, 'updateBasicInfo'])->middleware('role_permission:update.order');
    Route::post('/update-property-info/{id}', [OrderController::class, 'updatePropertyInfo'])->middleware('role_permission:update.order');
    Route::post('/update-appraisal-info/{id}', [OrderController::class, 'updateAppraisalInfo'])->middleware('role_permission:update.order');
    Route::post('/update-client-info/{id}', [OrderController::class, 'updateClientInfo']);
    Route::post('/update-borrower-info/{id}', [OrderController::class, 'updateBorrowerInfo'])->middleware('role_permission:update.order');
    Route::post('/update-contact-info/{id}', [OrderController::class, 'updateContactInfo'])->middleware('role_permission:update.order');

    //order workflow
    Route::post('/update-order-schedule', [OrderWorkflowController::class, 'updateOrderSchedule']);
    Route::post('/delete-schedule/{id}', [OrderWorkflowController::class, 'deleteSchedule']);
    Route::post('/save-initial-review', [OrderWorkflowController::class, 'saveInitialReview']);
    Route::post('/save-quality-assurance', [OrderWorkflowController::class, 'saveQualityAssurance']);
    Route::post('/update-quality-assurance', [OrderWorkflowController::class, 'updateQualityAssurance']);
    Route::post('/save-com/{id}', [OrderWorkflowController::class, 'saveCom']);
    Route::post('/save-com-route', [OrderWorkflowController::class, 'saveComRoute']);


    //Appraisal Type
    Route::get(
        'appraisal-types',
        [AppraisalTypeController::class, 'index']
    )->middleware('role_permission:view.appraisaltype')->name('appraisal-types.index');
    Route::get(
        'appraisal-types/create',
        [AppraisalTypeController::class, 'create']
    )->middleware('role_permission:create.appraisaltype')->name('appraisal-types.create');
    Route::post(
        'appraisal-types',
        [AppraisalTypeController::class, 'store']
    )->middleware('role_permission:create.appraisaltype')->name('appraisal-types.store');
    Route::get(
        'appraisal-types/{id}',
        [AppraisalTypeController::class, 'show']
    )->middleware('role_permission:view.appraisaltype')->name('appraisal-types.show');
    Route::get(
        'appraisal-types/{id}/edit',
        [AppraisalTypeController::class, 'edit']
    )->middleware('role_permission:update.appraisaltype')->name('appraisal-types.edit');
    Route::put(
        'appraisal-types/{id}',
        [AppraisalTypeController::class, 'update']
    )->middleware('role_permission:update.appraisaltype')->name('appraisal-types.update');
    Route::post(
        'appraisal-types/{id}',
        [AppraisalTypeController::class, 'destroy']
    )->middleware('role_permission:delete.appraisaltype')->name('appraisal-types.destroy');
    //Loan Type
    Route::get(
        'loan-types',
        [LoanTypeController::class, 'index']
    )->middleware('role_permission:view.loantype')->name('loan-types.index');
    Route::get(
        'loan-types/create',
        [LoanTypeController::class, 'create']
    )->middleware('role_permission:create.loantype')->name('loan-types.create');
    Route::post(
        'loan-types',
        [LoanTypeController::class, 'store']
    )->middleware('role_permission:create.loantype')->name('loan-types.store');
    Route::get(
        'loan-types/{id}',
        [LoanTypeController::class, 'show']
    )->middleware('role_permission:view.loantype')->name('loan-types.show');
    Route::get(
        'loan-types/{id}/edit',
        [LoanTypeController::class, 'edit']
    )->middleware('role_permission:update.loantype')->name('loan-types.edit');
    Route::put(
        'loan-types/{id}',
        [LoanTypeController::class, 'update']
    )->middleware('role_permission:update.loantype')->name('loan-types.update');
    Route::post(
        'loan-types/{id}',
        [LoanTypeController::class, 'destroy']
    )->middleware('role_permission:delete.loantype')->name('loan-types.destroy');

    //Marketing routes
    Route::get(
        'marketing',
        [MarketingController::class, 'index']
    )->middleware('role_permission:view.marketing')->name('marketing.index');
    Route::post('save-marketing-client',[MarketingController::class,'saveMarketingClient']);
    Route::post('save-marketing-client-category',[MarketingController::class,'saveMarketingClientCategory']);
    Route::post('filter-users',[MarketingController::class,'filterUsers']);
    Route::post('save-assigned-users',[MarketingController::class,'saveAssignedUsers']);
    Route::post('save-status',[MarketingController::class,'saveStatus']);
    Route::post('update-status',[MarketingController::class,'updateStatus']);
    Route::post('change-client-status',[MarketingController::class,'changeClientStatus']);
    Route::post('create-client-comment',[MarketingController::class, 'createClientComment']);


    //call routes
    Route::get('call', [CallController::class, 'index'])->middleware('role_permission:view.call')->name('call.index');
    Route::post('search/call/order', [CallController::class, 'searchCallOrder'])->middleware('role_permission:view.call')->name('call.search');
    Route::post('send-message', [CallController::class, 'sendMessage']);

    //notifications
    Route::get('notifications', [NotificationController::class, 'index']);
});
Auth::routes();

Route::any('/import-client', [ClientController::class, 'importClient'])->name('import-client');
Route::redirect('/', '/login');
Route::view('/404', 'dashboard.error');
Route::view('/403', 'dashboard.error-403');
Route::view('/order', 'dashboard.order');
Route::view('/order-details', 'dashboard.order-details')->name('order.details');
Route::view('/order-add', 'dashboard.order-add')->name('order.add');
Route::view('/order-add-step2', 'dashboard.order-add-step2')->name('order.add-step2');
Route::get('get/icons', [IconController::class, 'index'])->name('get.icon');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('accept-new-user/{code}', [UserController::class, 'acceptInviteUser'])->name('accept.new.user');
Route::post('invite-user-update/{id}', [UserController::class, 'inviteUserUpdate'])->name('update.invite.user.profile');
Route::get('/public-order/{id}', [OrderController::class, 'publicOrder'])->name('public.order');
Route::post('/upload-order-files/{id}', [OrderController::class, 'uploadOrderFiles'])->name('order.file.upload');

Route::get('/public-com/{id}',[OrderWorkflowController::class, 'publicCom']);
Route::post('/public-com-files/{id}',[OrderWorkflowController::class, 'publicComFiles'])->name('public.com.files');

Route::post('/search/order/by/filter', [OrderController::class, 'searchOrderByFiltering'])->name('searchOrderByFiltering');


//workflow
Route::post('/upload-inspection-files/{id}', [OrderWorkflowController::class, 'uploadInspectionFiles'])->name('inspection.file.upload');
Route::post('/admin-report-preparation-create/{id}', [OrderWorkflowController::class, 'storeAdminReportPreparation'])->name('report.preparation.create');
Route::post('/assignee-report-preparation-create/{id}', [OrderWorkflowController::class, 'storeAssigneeReportPreparation'])->name('assignee.preparation.create');
Route::post('/report-analysis-create/{id}', [OrderWorkflowController::class, 'storeReportAnalysis'])->name('report.analysis.create');
Route::post('/submission-create/{id}', [OrderWorkflowController::class, 'storeSubmission'])->name('submission.create');
Route::post('rewrite-report/update/', [OrderWorkflowController::class, 'rewriteReport']);
Route::post('rewrite-report/update/assignee', [OrderWorkflowController::class, 'rewriteReportAssignee']);

Route::post('revissin/add', [OrderWorkflowController::class, 'revissinAdd']);
Route::post('revissin/edit', [OrderWorkflowController::class, 'revissinEdit']);
Route::post('revissin/solutions/add', [OrderWorkflowController::class, 'revissinSolutionAdd']);
Route::post('revissin/solutions/marked', [OrderWorkflowController::class, 'revissinSolutionMarked']);
Route::post('revissin/solutions/delete', [OrderWorkflowController::class, 'revissinSolutionDelete']);
Route::post('check/client/order/no', [OrderWorkflowController::class, 'checkClientOrderNo']);

//Route::get( "{slug}", [ WebApiController::class, 'home' ] )->where( 'slug', ".*" );

Route::get('/auth-user', [UserController::class, 'authUser']);
Route::get('/user-list', [UserController::class, 'userList']);

Route::get('/notification', function () {
    return view('notification');
});

Route::get('send',[PusherNotificationController::class, 'notification']);

Route::get('/event',function () {
    event(new Notify('Hey how are you!', 2));
});

Route::get('/get/timezone', function(){
    $timezone = date_default_timezone_get();
    return $timezone;
});

Route::get('/listen',function () {
    return view('listen');
});
