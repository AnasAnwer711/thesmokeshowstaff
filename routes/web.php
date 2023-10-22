<?php
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BasicSettingController;
use App\Http\Controllers\CancellationPolicyController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\DisputeBookingController;
use App\Http\Controllers\DisputeTitleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\EntityTypeController;
use App\Http\Controllers\FindStaffController;
use App\Http\Controllers\FooterSocialLinkController;
use App\Http\Controllers\HelpfulKeyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\JobApplicantController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PaymentConfigurationController;
use App\Http\Controllers\ReferralProgramController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StaffCategoryController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMessagesController;
use App\Http\Controllers\UserNotificationsController;
use App\Http\Controllers\UserReviewsController;
use App\Http\Controllers\UserShortlistController;
use App\Http\Controllers\UserSkillController;
use App\Http\Controllers\UserTransactionController;
use App\Http\Controllers\ViolationController;
use App\Models\UserReview;

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
// HOME ROTUE
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/howitworks', [MainController::class, 'howitworks'])->name('howitworks');
Route::get('/faqs', [MainController::class, 'faqs'])->name('faqs');
Route::get('/privacypolicy', [MainController::class, 'privacypolicy'])->name('privacypolicy');
Route::get('/termsandconditions', [MainController::class, 'termsandconditions'])->name('termsandconditions');
Route::get('/contactus', [MainController::class, 'contactus'])->name('contactus');
Route::get('/get_contactus_details/{job_id}', [MainController::class, 'get_contactus_details'])->name('get_contactus_details');
Route::post('/contactus', [MainController::class, 'doContactUs'])->name('doContactUs');

//LOGIN SIGNUP ROUTES
Route::get('login', [RegisterController::class, 'login'])->name('login')->middleware('guest');
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/addToken', [UserController::class, 'addToken'])->name('addToken');
Route::post('/doLogin', [RegisterController::class, 'doLogin'])->name('doLogin');
Route::get('/signup', [RegisterController::class, 'signup'])->name('signup')->middleware('guest');
Route::post('/doSignup', [RegisterController::class, 'doSignup'])->name('doSignup');
Route::post('/sendOtp', [RegisterController::class, 'sendOtp'])->name('sendOtp');


Route::group(['middleware' => ['role:admin|super-admin', 'auth']], function () {
    Route::prefix('admin')->group(function() {
        Route::get('/', [AdminController::class, 'defaultSettings'])->name('admin-panel');
        Route::get('/default-settings', [AdminController::class, 'defaultSettings'])->name('default-settings');
        Route::get('/staff-requests', [AdminController::class, 'staffRequests'])->name('staff-requests');
        Route::get('/get-staff-requests', [UserController::class, 'staffRequests']);
        Route::get('/profile/{user}', [UserController::class, 'viewProfile']);
        Route::get('/profile/{user}/show', [UserController::class, 'show']);
        Route::post('/users/change_status', [UserController::class, 'changeStatus']);
        Route::get('/get-basic-settings', [BasicSettingController::class, 'getBasicSettings']);
        Route::post('/save-basic-settings', [BasicSettingController::class, 'store']);
        Route::get('/get-payment-configuration', [PaymentConfigurationController::class, 'getPaymentConfiguration']);
        Route::post('/save-payment-configuration', [PaymentConfigurationController::class, 'store']);
        Route::get('/get-cancellation-policies', [CancellationPolicyController::class, 'getCancellationPolicies']);
        Route::post('/delete-cancellation-policy', [CancellationPolicyController::class, 'destroy']);
        Route::post('/save-cancellation-policy', [CancellationPolicyController::class, 'store']);
        Route::get('/get-currencies', [PaymentConfigurationController::class, 'getCurrencies']);
        Route::get('/get-social-links', [FooterSocialLinkController::class, 'getSocialLinks']);
        Route::post('/save-social-link', [FooterSocialLinkController::class, 'store']);
        Route::post('/delete-social-link', [FooterSocialLinkController::class, 'destroy']);
        Route::get('/jobs', [AdminController::class, 'jobs'])->name('admin-jobs');
        Route::post('/jobs/mark-completed', [JobController::class, 'complete']);
        Route::post('/jobs/mark-close', [JobController::class, 'close']);
        Route::get('/staff-categories', [AdminController::class, 'staffCategories'])->name('admin-staff-categories');
        Route::get('/get-staff-categories', [StaffCategoryController::class, 'getStaffCategories']);
        Route::get('/get-categories', [StaffCategoryController::class, 'getCategories']);
        Route::post('/save-staff-category', [StaffCategoryController::class, 'store']);
        Route::post('/delete-staff-category', [StaffCategoryController::class, 'destroy']);
        Route::get('/subscription-plans', [AdminController::class, 'subscriptionPlans'])->name('admin-subscription-plans');
        Route::get('/get-subscription-plans', [SubscriptionPlanController::class, 'getSubscriptionPlans']);
        Route::post('/save-subscription-plan', [SubscriptionPlanController::class, 'store']);
        Route::post('/delete-subscription-plan', [SubscriptionPlanController::class, 'destroy']);
        Route::get('/helpful-keys', [AdminController::class, 'helpfulKeys'])->name('admin-helpful-keys');
        Route::get('/get-helpful-keys', [HelpfulKeyController::class, 'getHelpfulKeys']);
        Route::post('/save-helpful-key', [HelpfulKeyController::class, 'store']);
        Route::post('/delete-helpful-key', [HelpfulKeyController::class, 'destroy']);
        Route::get('/his_skills/{user}', [UserSkillController::class, 'his_skills']);
        Route::post('/change_job_application_status', [InvitationController::class, 'change_job_application_status']);
        Route::get('/disputes', [AdminController::class, 'disputes'])->name('admin-disputes');
        Route::get('/get-disputes', [DisputeBookingController::class, 'getDisputes']);
        Route::post('/resolve-dispute', [DisputeBookingController::class, 'resolveDispute']);
        Route::get('/violates', [AdminController::class, 'violates'])->name('admin-violates');
        Route::get('/violates/{violate_id}', [AdminController::class, 'violate_detail'])->name('violate-detail');
        Route::get('/get-violates', [ViolationController::class, 'getViolates']);
        Route::post('/update-violation', [ViolationController::class, 'updateViolation']);
        Route::get('/messages', [AdminController::class, 'jobChats'])->name('admin-job-chats');
        Route::get('/job-messages', [UserMessagesController::class, 'getJobMessages']);
        //Users Listing for Admin
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/get-users', [UserController::class, 'getUsers'])->name('get-users');
    });
});
Route::get('/payment_configuration', [PaymentConfigurationController::class, 'payment_configuration'])->name('payment-configuration');
Route::get('/basic_setting', [BasicSettingController::class, 'getBasicSettings'])->name('basic-setting');
Route::get('/languages', [MainController::class, 'languages'])->name('languages');
Route::get('build_types', [MainController::class, 'build_types'])->name('build-types');
Route::get('states', [MainController::class, 'states'])->name('states');

// find-staff
Route::get('/find_staff/{type?}', [FindStaffController::class, 'find_staff'])->name('find-staff');
Route::post('/get_staff', [FindStaffController::class, 'get_staff'])->name('get-staff');
Route::get('/find_staff/{id}/detail', [FindStaffController::class, 'staff_detail'])->name('staff-detail');
Route::get('/get_staff_detail/{id}', [FindStaffController::class, 'get_staff_detail'])->name('get-staff-detail');

Route::resource('staff_categories', StaffCategoryController::class);

Route::get('/get_profile', [UserController::class, 'get_profile'])->name('get-profile')->middleware('auth');

Route::get('/get-message-count', [UserMessagesController::class, 'getMessageCount'])->middleware('auth');

Route::group(['middleware' => ['payment_module_verified']],function () {

    Route::group(['middleware' => ['role:host', 'auth', 'profile_detail_provided', 'profile_is_approved']], function () {
        Route::post('/contact-staff', [UserMessagesController::class, 'contactStaff']);
        Route::post('/job-user-messages', [UserMessagesController::class, 'getJobUserMessages']);
        
        //host profile picture
        Route::post('/update_host_picture', [UserController::class, 'update_host_picture'])->name('update-host-picture');
    
        // packages
        Route::resource('job', JobController::class);
    
        //subscription-plan
        Route::resource('subscription_plans', SubscriptionPlanController::class);
        Route::get('get_subscription_plans', [SubscriptionPlanController::class, 'get_packages'])->name('get-packages');
        
        //subscription
        Route::resource('subscriptions', SubscriptionController::class);
        Route::get('get_subscription', [SubscriptionController::class, 'get_subscription'])->name('get-subscription');
    
        //referral_program
        Route::get('referral_program', [ReferralProgramController::class, 'index'])->name('referral-program');
        Route::post('referral_program', [ReferralProgramController::class, 'store'])->name('send-referral-program');
    });
    
    Route::group(['middleware' => ['role:staff', 'auth', 'skill_provided', 'profile_detail_provided', 'profile_is_approved']], function () {
    
        // application
        Route::resource('applications', ApplicationController::class);
        Route::get('/get_applicants', [ApplicationController::class, 'get_applicants'])->name('get-applicants');
        Route::post('accept_invitation/{job_applicant_id}', [InvitationController::class, 'accept_invitation'])->name('accept-invitation');
        Route::post('/send-inquiry', [UserMessagesController::class, 'sendInquiry']);
    
        
    });
    
    Route::group(['middleware' => ['auth']], function(){
        Route::get('/chat-detail', [UserMessagesController::class, 'chatDetail']);
        // Payment Routes
    
        Route::post('/messages', [UserMessagesController::class, 'getMessages']);
        Route::group(['middleware' => ['profile_detail_provided', 'profile_is_approved']], function(){
            Route::get('/chats', [UserMessagesController::class, 'getChats']);
            Route::post('/send-message', [UserMessagesController::class, 'sendMessage']);
            Route::post('/save-fcm-token', [UserMessagesController::class, 'saveFcmToken']);
            Route::get('/get-notification-count', [UserNotificationsController::class, 'getNotificationCount']);
            Route::post('/delete-chat', [UserMessagesController::class, 'deleteChat']);
    
            //add to shortlist route
            Route::get('/get_shortlists', [UserShortlistController::class, 'get_shortlists'])->name('get-shortlists');
            Route::resource('shortlists', UserShortlistController::class);
    
            // transaction
            Route::resource('transaction', UserTransactionController::class);
            Route::get('get_transactions', [UserTransactionController::class, 'get_transactions'])->name('get-transactions');
    
            // credit card
            Route::resource('credit_card', CreditCardController::class);
            Route::get('get_cards', [CreditCardController::class, 'get_cards'])->name('get-cards');
    
            // reviews
            Route::resource('reviews', UserReviewsController::class);
            Route::get('my_reviews', [UserReviewsController::class, 'my_reviews'])->name('my-reviews');
            
            // invitations 
            Route::resource('invitations', InvitationController::class);
            Route::get('get_invitation/{job_id}', [InvitationController::class, 'get_invitation'])->name('get-invitation');
            Route::post('accept_application/{job_applicant_id}', [InvitationController::class, 'accept_application'])->name('accept-application');
            Route::post('change_job_application_status', [InvitationController::class, 'change_job_application_status'])->name('change-job-application-status');
    
        });
    
    
        // job routes
        Route::get('/find_job', [JobController::class, 'find_job'])->name('find-job');
        Route::get('/get_jobs', [JobController::class, 'get_jobs'])->name('get-jobs');
        Route::get('/get_user_jobs', [JobController::class, 'get_user_jobs'])->name('get-user-jobs');
        Route::get('/get_job/{id}', [JobController::class, 'get_job'])->name('get-job');
        Route::get('/duplicate_job/{id}', [JobController::class, 'duplicate_job'])->name('duplicate-job');
        Route::post('/change_job_status/{id}', [JobController::class, 'change_job_status'])->name('change-job-status');
    
    
        Route::get('/get_cancellation_policy/{user_type}', [CancellationPolicyController::class, 'get_cancellation_policy'])->name('get-cancellation-policy');
    
        Route::get('/entity_types', [EntityTypeController::class, 'index'])->name('entity-types');
        Route::post('/save_profile', [UserController::class, 'save_profile'])->name('save-profile');
        Route::post('/save-skill-photo', [UserController::class, 'saveSkillPhoto']);
        Route::post('/delete-skill-photo', [UserController::class, 'deleteSkillPhoto']);
        Route::post('/set-default-skill-photo', [UserController::class, 'setDefaultSkillPhoto']);
        Route::post('/change_password', [UserController::class, 'change_password'])->name('change-password');
        
        // staff profile picture
        Route::post('/update_profile_picture', [UserController::class, 'update_profile_picture'])->name('update-profile-picture');
            
        // start of routes without payment module verification middleware to access profile page
            Route::get('/profile', [UserController::class, 'index'])->name('profile')->withoutMiddleware('payment_module_verified');
            Route::get('nationalities', [MainController::class, 'nationalities'])->name('nationalities')->withoutMiddleware('payment_module_verified');
            // staff category routes
            Route::get('my_skills', [UserSkillController::class, 'my_skills'])->name('my-skills')->withoutMiddleware('payment_module_verified');
        // end of routes without payment module verification middleware to access profile page

        Route::resource('user_skills', UserSkillController::class);
        Route::get('all_skills', [UserSkillController::class, 'all_skills'])->name('all-skills');
    
        // job applicant routes
        Route::resource('job_applicant', JobApplicantController::class);
        Route::get('get_applicant_job_ids/{applicant_id}', [JobApplicantController::class, 'get_applicant_job_ids'])->name('get-applicant-job-ids');
        
    
        //travel allowance routes
        Route::get('travel_allowances', [MainController::class, 'travel_allowances']);
        
        
        //feedback routes
        Route::resource('rating', UserReviewsController::class);
        
        //dispute title routes
        Route::get('dispute_titles', [DisputeTitleController::class, 'index']);
     
        //dispute booking routes
        Route::resource('dispute_booking', DisputeBookingController::class);
    
        
        //extended booking routes
        Route::post('extended_booking', [JobApplicantController::class, 'extended_booking']);
    
    
    
        
        Route::get('test_email', [MainController::class, 'test_email']);
    
        // user notifications
        Route::get('see-all-notifications', [UserNotificationsController::class, 'seeAllNotifications'])->name('see-all-notifications');
        Route::get('get-all-notifications', [UserNotificationsController::class, 'getAllNotifications'])->name('get-all-notifications');
        Route::delete('notification/{id}', [UserNotificationsController::class, 'destroy'])->name('destroy-notification');
        Route::delete('delete_all_notifications', [UserNotificationsController::class, 'delete_all_notifications'])->name('delete-all-notifications');
    
        // user messages
        Route::get('/messages', [UserMessagesController::class, 'messages'])->name('messages');
        
    });
});




    
    