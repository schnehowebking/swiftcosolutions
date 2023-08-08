<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\IncomeTypeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\AttendanceEmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\AccountListController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\SetSalaryController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\AwardTypeController;
use App\Http\Controllers\TerminationController;
use App\Http\Controllers\TerminationTypeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\PaySlipController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\WarningController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PayeesController;
use App\Http\Controllers\PayerController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransferBalanceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DucumentUploadController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\GoalTypeController;
use App\Http\Controllers\GoalTrackingController;
use App\Http\Controllers\CompanyPolicyController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\OtherPaymentController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobStageController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\CustomQuestionController;
use App\Http\Controllers\InterviewScheduleController;
use App\Http\Controllers\LandingPageSectionController;
use App\Http\Controllers\CompetenciesController;
use App\Http\Controllers\PerformanceTypeController;
use App\Http\Controllers\ZoomMeetingController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\SaturationDeductionController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DeductionOptionController;
use App\Http\Controllers\LoanOptionController;
use App\Http\Controllers\AllowanceOptionController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\PayslipTypeController;
use App\Http\Controllers\Frontend\CompanyFrontendController;
use App\Http\Controllers\Frontend\ElearningFrontendController;
use App\Http\Controllers\Frontend\JobFrontendController;

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


// Route::get('/', function () {
//     return view('frontend.companyfrontend.index');
// });
//
Route::get('/', [CompanyFrontendController::class, 'index']);
Route::get('/learning', [ElearningFrontendController::class, 'index']);
Route::get('/learning/create', [ElearningFrontendController::class, 'create'])->name('frontend.training.create');
Route::post('/learning/store', [ElearningFrontendController::class, 'store'])->name('frontend.training.store');
Route::get('/learning/show/{id}', [ElearningFrontendController::class, 'show'])->name('frontend.training.show');

Route::get('/jobs', [JobFrontendController::class, 'index'])->name('frontend.joblist');
Route::post('/jobs/store', [JobFrontendController::class, 'store'])->name('frontend.jobs.store');
Route::get('/jobs/show/{id}', [JobFrontendController::class, 'show'])->name('frontend.job.show');
Route::get('/about', function () { return view('frontend.company.about');});
Route::get('/services', function () { return view('frontend.company.service');});
Route::get('/pricing', function () { return view('frontend.company.pricing');});
Route::get('/projects', function () { return view('frontend.company.project');});
Route::get('/contact', function () { return view('frontend.company.contact');});


require __DIR__ . '/auth.php';

Route::get('/check', [HomeController::class, 'check'])->middleware(
    [
        'auth',
        'XSS',
    ]
);
// Route::get('/password/resets/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['XSS']);


// Route::group(['middleware' => ['verified']], function () {

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth','XSS'])->name('dashboard');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/home/getlanguvage', [HomeController::class, 'getlanguvage'])->name('home.getlanguvage');

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::resource('settings', SettingsController::class);
        Route::post('email-settings', [SettingsController::class, 'saveEmailSettings'])->name('email.settings');
        Route::post('company-settings', [SettingsController::class, 'saveCompanySettings'])->name('company.settings');
        Route::post('system-settings', [SettingsController::class, 'saveSystemSettings'])->name('system.settings');
        Route::get('company-setting', [SettingsController::class, 'companyIndex'])->name('company.setting');
        Route::get('company-email-setting/{name}', [EmailTemplateController::class, 'updateStatus'])->name('company.email.setting');
        // Route::post('company-email-setting/{name}', 'EmailTemplateController@updateStatus')->name('status.email.language')->middleware(['auth']);

        Route::post('pusher-settings', [SettingsController::class, 'savePusherSettings'])->name('pusher.settings');
        Route::post('business-setting', [SettingsController::class, 'saveBusinessSettings'])->name('business.setting');

        Route::post('zoom-settings', [SettingsController::class, 'zoomSetting'])->name('zoom.settings');

        Route::get('test-mail', [SettingsController::class, 'testMail'])->name('test.mail');
        Route::post('test-mail', [SettingsController::class, 'testMail'])->name('test.mail');
        Route::post('test-mail/send', [SettingsController::class, 'testSendMail'])->name('test.send.mail');

        Route::get('create/ip', [SettingsController::class, 'createIp'])->name('create.ip');
        Route::post('create/ip', [SettingsController::class, 'storeIp'])->name('store.ip');
        Route::get('edit/ip/{id}', [SettingsController::class, 'editIp'])->name('edit.ip');
        Route::post('edit/ip/{id}', [SettingsController::class, 'updateIp'])->name('update.ip');
        Route::delete('destroy/ip/{id}', [SettingsController::class, 'destroyIp'])->name('destroy.ip');
    }
);

// Email Templates
Route::get('email_template_lang/{id}/{lang?}', [EmailTemplateController::class, 'manageEmailLang'])->name('manage.email.language')->middleware(['auth', 'XSS']);
Route::post('email_template_store/{pid}', [EmailTemplateController::class, 'storeEmailLang'])->name('store.email.language')->middleware(['auth']);
Route::post('email_template_status/{id}', [EmailTemplateController::class, 'updateStatus'])->name('status.email.language')->middleware(['auth']);

Route::resource('email_template', EmailTemplateController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('email_template_lang', EmailTemplateLangController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/test',

    [SettingsController::class, 'testEmail']
)->name('test.email')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/test/send',
    [SettingsController::class, 'testEmailSend']

)->name('test.email.send')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End

Route::resource('user', UserController::class)
    ->middleware(
        [
            'auth',
            'XSS',
        ]
    );
Route::post('employee/json', [EmployeeController::class, 'json'])->name('employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('branch/employee/json', [EmployeeController::class, 'employeeJson'])->name('branch.employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee-profile', [EmployeeController::class, 'profile'])->name('employee.profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('show-employee-profile/{id}', [EmployeeController::class, 'profileShow'])->name('show.employee.profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('lastlogin', [EmployeeController::class, 'lastLogin'])->name('lastlogin')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('employee', EmployeeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('otherpayments/create/{eid}', [OtherPaymentController::class, 'otherpaymentCreate'])->name('otherpayments.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('otherpayment', OtherPaymentController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('paymenttype', PaymentTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('department', DepartmentController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('designation', DesignationController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('document', DocumentController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('branch', BranchController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('awardtype', AwardTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('award', AwardController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('termination/{id}/description', [TerminationController::class, 'description'])->name('termination.description');

Route::resource('termination', TerminationController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('terminationtype', TerminationTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('announcement/getdepartment', [AnnouncementController::class, 'getdepartment'])->name('announcement.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('announcement/getemployee', [AnnouncementController::class, 'getemployee'])->name('announcement.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('announcement', AnnouncementController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get('holiday/calender', [HolidayController::class, 'calender'])->name('holiday.calender')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('holiday', HolidayController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get('employee/salary/{eid}', [SetSalaryController::class, 'employeeBasicSalary'])->name('employee.basic.salary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('allowances/create/{eid}', [AllowanceController::class, 'allowanceCreate'])->name('allowances.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('commissions/create/{eid}', [CommissionController::class, 'commissionCreate'])->name('commissions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('loans/create/{eid}', [LoanController::class, 'loanCreate'])->name('loans.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('saturationdeductions/create/{eid}', [SaturationDeductionController::class, 'saturationdeductionCreate'])->name('saturationdeductions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('overtimes/create/{eid}', [OvertimeController::class, 'overtimeCreate'])->name('overtimes.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);


//payslip

Route::resource('paysliptype', PayslipTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('allowance', AllowanceController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('commission', CommissionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('allowanceoption', AllowanceOptionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('loanoption', LoanOptionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('deductionoption', DeductionOptionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('loan', LoanController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('saturationdeduction', SaturationDeductionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('overtime', OvertimeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('event/getdepartment', [EventController::class, 'getdepartment'])->name('event.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('event/getemployee', [EventController::class, 'getemployee'])->name('event.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('event/data/{id}', [EventController::class, 'showData'])->name('eventsshow');
Route::resource('event', EventController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);



Route::get('import/event/file', [EventController::class, 'importFile'])->name('event.file.import');
Route::post('import/event', [EventController::class, 'import'])->name('event.import');
Route::get('export/event', [EventController::class, 'export'])->name('event.export');

Route::post('meeting/getdepartment', [MeetingController::class, 'getdepartment'])->name('meeting.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('meeting/getemployee', [MeetingController::class, 'getemployee'])->name('meeting.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('meeting', MeetingController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('calender/meeting', [MeetingController::class, 'calender'])->name('meeting.calender')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('employee/update/sallary/{id}', [SetSalaryController::class, 'employeeUpdateSalary'])->name('employee.salary.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('salary/employeeSalary', [SetSalaryController::class, 'employeeSalary'])->name('employeesalary')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('setsalary', SetSalaryController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('payslip/paysalary/{id}/{date}', [PaySlipController::class, 'paysalary'])->name('payslip.paysalary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/bulk_pay_create/{date}', [PaySlipController::class, 'bulk_pay_create'])->name('payslip.bulk_pay_create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/bulkpayment/{date}', [PaySlipController::class, 'bulkpayment'])->name('payslip.bulkpayment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/search_json', [PaySlipController::class, 'search_json'])->name('payslip.search_json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/employeepayslip', [PaySlipController::class, 'employeepayslip'])->name('payslip.employeepayslip')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/showemployee/{id}', [PaySlipController::class, 'showemployee'])->name('payslip.showemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/editemployee/{id}', [PaySlipController::class, 'editemployee'])->name('payslip.editemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('payslip/editemployee/{id}', [PaySlipController::class, 'updateEmployee'])->name('payslip.updateemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/pdf/{id}/{m}', [PaySlipController::class, 'pdf'])->name('payslip.pdf')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/payslipPdf/{id}', [PaySlipController::class, 'payslipPdf'])->name('payslip.payslipPdf')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/send/{id}/{m}', [PaySlipController::class, 'send'])->name('payslip.send')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('payslip/delete/{id}', [PaySlipController::class, 'destroy'])->name('payslip.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('payslip', PaySlipController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('resignation', ResignationController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('travel', TravelController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('promotion', PromotionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('transfer', TransferController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('complaint', ComplaintController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('warning', WarningController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('edit-profile', [UserController::class, 'editprofile'])->name('update.account')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('accountlist', AccountListController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('accountbalance', [AccountListController::class, 'account_balance'])->name('accountbalance')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get('leave/{id}/action', [LeaveController::class, 'action'])->name('leave.action')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('leave/changeaction', [LeaveController::class, 'changeaction'])->name('leave.changeaction')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('leave/jsoncount', [LeaveController::class, 'jsoncount'])->name('leave.jsoncount')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('leave', LeaveController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('calender/leave', [LeaveController::class, 'calender'])->name('leave.calender')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('ticket/{id}/reply', [TicketController::class, 'reply'])->name('ticket.reply')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('ticket/changereply', [TicketController::class, 'changereply'])->name('ticket.changereply')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('ticket', TicketController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('attendanceemployee/bulkattendance', [AttendanceEmployeeController::class, 'bulkAttendance'])->name('attendanceemployee.bulkattendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('attendanceemployee/bulkattendance', [AttendanceEmployeeController::class, 'bulkAttendanceData'])->name('attendanceemployee.bulkattendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('attendanceemployee/attendance', [AttendanceEmployeeController::class, 'attendance'])->name('attendanceemployee.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('attendanceemployee', AttendanceEmployeeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('timesheet', TimeSheetController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('expensetype', ExpenseTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('incometype', IncomeTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('leavetype', LeaveTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('payees', PayeesController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('payer', PayerController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('deposit', DepositController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('expense', ExpenseController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('transferbalance', TransferBalanceController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language');
        Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language');
        Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data');
        Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language');
        Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language');
        Route::delete('/lang/{id}', [LanguageController::class, 'destroyLang'])->name('lang.destroy');
    }
);

Route::resource('roles', RoleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('permissions', PermissionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('change-password', [UserController::class, 'updatePassword'])->name('update.password');

Route::resource('coupons', CouponController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('account-assets', AssetController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('document-upload', DucumentUploadController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('indicator', IndicatorController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('appraisal', AppraisalController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('goaltype', GoalTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('goaltracking', GoalTrackingController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('company-policy', CompanyPolicyController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('trainingtype', TrainingTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('trainer', TrainerController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('training/status', [TrainingController::class, 'updateStatus'])->name('training.status')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('training', TrainingController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('report/income-expense', [ReportController::class, 'incomeVsExpense'])->name('report.income-expense')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/leave', [ReportController::class, 'leave'])->name('report.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee/{id}/leave/{status}/{type}/{month}/{year}', [ReportController::class, 'employeeLeave'])->name('report.employee.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/account-statement', [ReportController::class, 'accountStatement'])->name('report.account.statement')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/payroll', [ReportController::class, 'payroll'])->name('report.payroll')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/monthly/attendance', [ReportController::class, 'monthlyAttendance'])->name('report.monthly.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('report/attendance/{month}/{branch}/{department}', [ReportController::class, 'exportCsv'])->name('report.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('report/timesheet', [ReportController::class, 'timesheet'])->name('report.timesheet')->middleware(
    [
        'auth',
        'XSS',
    ]
);


//------------------------------------  Recurtment --------------------------------

Route::resource('job-category', JobCategoryController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('job-stage', JobStageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-stage/order', [JobStageController::class, 'order'])->name('job.stage.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('job', JobController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('career/{id}/{lang}', [JobController::class, 'career'])->name('career');
Route::get('job/requirement/{code}/{lang}', [JobController::class, 'jobRequirement'])->name('job.requirement');
Route::get('job/apply/{code}/{lang}', [JobController::class, 'jobApply'])->name('job.apply');
Route::post('job/apply/data/{code}', [JobController::class, 'jobApplyData'])->name('job.apply.data');


Route::get('candidates-job-applications', [JobApplicationController::class, 'candidate'])->name('job.application.candidate')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('job-application', JobApplicationController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('job-application/order', [JobApplicationController::class, 'order'])->name('job.application.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/{id}/rating', [JobApplicationController::class, 'rating'])->name('job.application.rating')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-application/{id}/archive', [JobApplicationController::class, 'archive'])->name('job.application.archive')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('job-application/{id}/skill/store', [JobApplicationController::class, 'addSkill'])->name('job.application.skill.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/{id}/note/store', [JobApplicationController::class, 'addNote'])->name('job.application.note.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-application/{id}/note/destroy', [JobApplicationController::class, 'destroyNote'])->name('job.application.note.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/getByJob', [JobApplicationController::class, 'getByJob'])->name('get.job.application')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get('job-onboard', [JobApplicationController::class, 'jobOnBoard'])->name('job.on.board')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('job-onboard/create/{id}', [JobApplicationController::class, 'jobBoardCreate'])->name('job.on.board.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/store/{id}', [JobApplicationController::class, 'jobBoardStore'])->name('job.on.board.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('job-onboard/edit/{id}', [JobApplicationController::class, 'jobBoardEdit'])->name('job.on.board.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/update/{id}', [JobApplicationController::class, 'jobBoardUpdate'])->name('job.on.board.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-onboard/delete/{id}', [JobApplicationController::class, 'jobBoardDelete'])->name('job.on.board.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('job-onboard/convert/{id}', [JobApplicationController::class, 'jobBoardConvert'])->name('job.on.board.convert')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/convert/{id}', [JobApplicationController::class, 'jobBoardConvertData'])->name('job.on.board.convert')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::post('job-application/stage/change', [JobApplicationController::class, 'stageChange'])->name('job.application.stage.change')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('custom-question', CustomQuestionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('interview-schedule', InterviewScheduleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('interview-schedule/create/{id?}', [InterviewScheduleController::class, 'create'])->name('interview-schedule.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);

//================================= Custom Landing Page ====================================//

// Route::get('/landingpage', 'LandingPageSectionController@index')->name('custom_landing_page.index')->middleware(['auth', 'XSS']);
Route::get('/LandingPage/show/{id}', [LandingPageSectionController::class, 'show']);
Route::post('/LandingPage/setConetent', [LandingPageSectionController::class, 'setConetent'])->middleware(['auth', 'XSS']);
Route::post('/LandingPage/removeSection/{id}', [LandingPageSectionController::class, 'removeSection'])->middleware(['auth', 'XSS']);
Route::post('/LandingPage/setOrder', [LandingPageSectionController::class, 'setOrder'])->middleware(['auth', 'XSS']);
Route::post('/LandingPage/copySection', [LandingPageSectionController::class, 'copySection'])->middleware(['auth', 'XSS']);


Route::resource('competencies', CompetenciesController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('performanceType', PerformanceTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//employee Import & Export
Route::get('import/employee/file', [EmployeeController::class, 'importFile'])->name('employee.file.import');
Route::post('import/employee', [EmployeeController::class, 'import'])->name('employee.import');
Route::get('export/employee', [EmployeeController::class, 'export'])->name('employee.export');

// Timesheet Import & Export

Route::get('import/timesheet/file', [TimeSheetController::class, 'importFile'])->name('timesheet.file.import');
Route::post('import/timesheet', [TimeSheetController::class, 'import'])->name('timesheet.import');
Route::get('export/timesheet', [TimeSheetController::class, 'export'])->name('timesheet.export');
Route::get('export/timesheet/export', [ReportController::class, 'exportTimeshhetReport'])->name('timesheet.report.export');

//leave export
Route::get('export/leave', [LeaveController::class, 'export'])->name('leave.export');
Route::get('export/leave/report', [ReportController::class, 'LeaveReportExport'])->name('leave.report.export');

//Account Statement Export
Route::get('export/accountstatement/report', [ReportController::class, 'AccountStatementReportExport'])->name('accountstatement.report.export');

//Payroll Export
Route::get('export/payroll', [ReportController::class, 'PayrollReportExport'])->name('payroll.report.export');

// payslip export
Route::post('export/payslip', [PaySlipController::class, 'PayslipExport'])->name('payslip.export');

//deposite Export
Route::get('export/deposite', [DepositController::class, 'export'])->name('deposite.export');

//expense Export
Route::get('export/expense', [ExpenseController::class, 'export'])->name('expense.export');

//Transfer Balance Export
Route::get('export/transfer-balance', [TransferBalanceController::class, 'export'])->name('transfer_balance.export');

//Training Import & Export
Route::get('export/training', [TrainingController::class, 'export'])->name('training.export');

//Trainer Export
Route::get('export/trainer', [TrainerController::class, 'export'])->name('trainer.export');
Route::get('import/training/file', [TrainerController::class, 'importFile'])->name('trainer.file.import');
Route::post('import/training', [TrainerController::class, 'import'])->name('trainer.import');

//Holiday Export & Import
Route::get('export/holidays', [HolidayController::class, 'export'])->name('holidays.export');
Route::get('import/holidays/file', [HolidayController::class, 'importFile'])->name('holidays.file.import');
Route::post('import/holidays', [HolidayController::class, 'import'])->name('holidays.import');

//Asset Import & Export
Route::get('export/assets', [AssetController::class, 'export'])->name('assets.export');
Route::get('import/assets/file', [AssetController::class, 'importFile'])->name('assets.file.import');
Route::post('import/assets', [AssetController::class, 'import'])->name('assets.import');

//zoom meeting
Route::any('zoommeeting/calendar', [ZoomMeetingController::class, 'calender'])->name('zoom_meeting.calender')->middleware(['auth', 'XSS']);
Route::resource('zoom-meeting', ZoomMeetingController::class)->middleware(['auth', 'XSS']);

//slack
Route::post('setting/slack', [SettingsController::class, 'slack'])->name('slack.setting');

//telegram
Route::post('setting/telegram', [SettingsController::class, 'telegram'])->name('telegram.setting');

//twilio
Route::post('setting/twilio', [SettingsController::class, 'twilio'])->name('twilio.setting');

// recaptcha
Route::post('/recaptcha-settings', [SettingsController::class, 'recaptchaSettingStore'])->name('recaptcha.settings.store')->middleware(['auth', 'XSS']);

// user reset password
Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('user.reset');
Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');

//contract
Route::resource('contract_type', ContractTypeController::class)->middleware(['auth', 'XSS']);
Route::resource('contract', ContractController::class)->middleware(['auth', 'XSS']);
Route::post('/contract_status_edit/{id}', [ContractController::class, 'contract_status_edit'])->name('contract.status')->middleware(['auth', 'XSS']);
Route::post('/contract/{id}/file', [ContractController::class, 'fileUpload'])->name('contracts.file.upload')->middleware(['auth', 'XSS']);
Route::get('/contract/{id}/file/{fid}',  [ContractController::class, 'fileDownload'])->name('contracts.file.download')->middleware(['auth', 'XSS']);
Route::get('/contract/{id}/file/delete/{fid}', [ContractController::class, 'fileDelete'])->name('contracts.file.delete')->middleware(['auth', 'XSS']);
Route::post('/contract/{id}/notestore', [ContractController::class, 'noteStore'])->name('contracts.note.store')->middleware(['auth']);
Route::get('/contract/{id}/note', [ContractController::class, 'noteDestroy'])->name('contracts.note.destroy')->middleware(['auth']);

Route::post('contract/{id}/description', [ContractController::class, 'descriptionStore'])->name('contracts.description.store')->middleware(['auth']);


Route::post('/contract/{id}/commentstore', [ContractController::class, 'commentStore'])->name('comment.store');
Route::get('/contract/{id}/comment', [ContractController::class, 'commentDestroy'])->name('comment.destroy');


Route::get('/contract/copy/{id}', [ContractController::class, 'copycontract'])->name('contracts.copy')->middleware(['auth', 'XSS']);
Route::post('/contract/copy/store/{id}', [ContractController::class, 'copycontractstore'])->name('contracts.copystore')->middleware(['auth', 'XSS']);

Route::get('contract/{id}/get_contract', [ContractController::class, 'printContract'])->name('get.contract');
Route::get('contract/pdf/{id}', [ContractController::class, 'pdffromcontract'])->name('contract.download.pdf');

// Route::get('/signature/{id}', 'ContractController@signature')->name('signature')->middleware(['auth','XSS']);
// Route::post('/signaturestore', 'ContractController@signatureStore')->name('signaturestore')->middleware(['auth','XSS']);

Route::get('/contract/{id}/mail', [ContractController::class, 'sendmailContract'])->name('send.mail.contract');
Route::get('/signature/{id}', [ContractController::class, 'signature'])->name('signature')->middleware(['auth', 'XSS']);
Route::post('/signaturestore', [ContractController::class, 'signatureStore'])->name('signaturestore')->middleware(['auth', 'XSS']);

//offer Letter
Route::post('setting/offerlatter/{lang?}', [SettingsController::class, 'offerletterupdate'])->name('offerlatter.update');
Route::get('setting/offerlatter', [SettingsController::class, 'index'])->name('get.offerlatter.language');
Route::get('job-onboard/pdf/{id}', [JobApplicationController::class, 'offerletterPdf'])->name('offerlatter.download.pdf');
Route::get('job-onboard/doc/{id}', [JobApplicationController::class, 'offerletterDoc'])->name('offerlatter.download.doc');

//joining Letter
Route::post('setting/joiningletter/{lang?}', [SettingsController::class, 'joiningletterupdate'])->name('joiningletter.update');
Route::get('setting/joiningletter/', [SettingsController::class, 'index'])->name('get.joiningletter.language');
Route::get('employee/pdf/{id}', [EmployeeController::class, 'joiningletterPdf'])->name('joiningletter.download.pdf');
Route::get('employee/doc/{id}', [EmployeeController::class, 'joiningletterDoc'])->name('joininglatter.download.doc');

//Experience Certificate
Route::post('setting/exp/{lang?}', [SettingsController::class, 'experienceCertificateupdate'])->name('experiencecertificate.update');
Route::get('setting/exp', [SettingsController::class, 'index'])->name('get.experiencecertificate.language');
Route::get('employee/exppdf/{id}', [EmployeeController::class, 'ExpCertificatePdf'])->name('exp.download.pdf');
Route::get('employee/expdoc/{id}', [EmployeeController::class, 'ExpCertificateDoc'])->name('exp.download.doc');

//NOC
Route::post('setting/noc/{lang?}', [SettingsController::class, 'NOCupdate'])->name('noc.update');
Route::get('setting/noc', [SettingsController::class, 'index'])->name('get.noc.language');
Route::get('employee/nocpdf/{id}', [EmployeeController::class, 'NocPdf'])->name('noc.download.pdf');
Route::get('employee/nocdoc/{id}', [EmployeeController::class, 'NocDoc'])->name('noc.download.doc');

//appricalStar
Route::post('/appraisals', [AppraisalController::class, 'empByStar'])->name('empByStar')->middleware(['auth', 'XSS']);
Route::post('/appraisals1', [AppraisalController::class, 'empByStar1'])->name('empByStar1')->middleware(['auth', 'XSS']);
Route::post('/getemployee', [AppraisalController::class, 'getemployee'])->name('getemployee');

//storage Setting
Route::post('storage-settings', [SettingsController::class, 'storageSettingStore'])->name('storage.setting.store')->middleware(['auth', 'XSS']);
// });

// Google Calendar
Route::post('setting/google-calender', [SettingsController::class, 'saveGoogleCalenderSettings'])->name('google.calender.settings')->middleware(['auth', 'XSS']);

// get calender
Route::any('event/get_event_data', [EventController::class, 'get_event_data'])->name('event.get_event_data')->middleware(['auth', 'XSS']);

Route::any('zoom-meeting/get_zoom_meeting_data', [ZoomMeetingController::class, 'get_zoom_meeting_data'])->name('zoommeeting.get_zoom_meeting_data')->middleware(['auth', 'XSS']);

Route::any('holiday/get_holiday_data', [HolidayController::class, 'get_holiday_data'])->name('holiday.get_holiday_data')->middleware(['auth', 'XSS']);

Route::any('/interview-schedule/get_interview-schedule_data', [InterviewScheduleController::class, 'get_interview_schedule_data'])->name('interview-schedule.get_interview-schedule_data')->middleware(['auth', 'XSS']);

Route::any('leave/get_leave_data', [LeaveController::class, 'get_leave_data'])->name('leave.get_leave_data')->middleware(['auth', 'XSS']);

Route::any('/meeting/get_meeting_data', [MeetingController::class, 'get_meeting_data'])->name('meeting.get_meeting_data')->middleware(['auth', 'XSS']);
