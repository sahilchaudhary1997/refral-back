<?php
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "admin" middleware group. Now create something great!
  |
 */
Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('adminLogin');
Route::post('/login', 'Admin\Auth\LoginController@doLogin')->name('adminLogin');
//Routes check with login and permission
Route::group(['middleware' => ['IsAdmin', 'AdminPermission'], 'namespace' => 'Admin'], function() {
    //Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('adminHome');
    Route::post('/fetchmobileusers', 'DashboardController@FetchMobileUsers')->name('fetchmobileusers');
	Route::post('/insertchatusers', 'DashboardController@InsertChatUsers')->name('insertchatusers');
	Route::post('/fetchuserchathistory', 'DashboardController@fetchUserChatHistoryData')->name('fetchuserchathistory');
    //Conatct Us Leads
    Route::get('/contact_leads', 'ContactLeadController@index')->name('adminContactLeads');
    Route::get('/contact_leads/delete/{id}', 'ContactLeadController@delete')->name('adminContactLeadsDelete');
    //Access Rights
    Route::get('/access_rights', 'AccessRightsController@index')->name('adminAccessRights');
    Route::post('/access_rights/update', 'AccessRightsController@update')->name('adminUpdateAccessRights');
    //General Settings
    Route::get('/general_settings', 'GeneralSettingController@index')->name('adminGeneralSettings');
    Route::post('/general_settings/update', 'GeneralSettingController@update')->name('adminUpdateGeneralSettings');
    //User Profile
    Route::get('/user_profile', 'UserProfileController@index')->name('adminUserProfile');
    Route::post('/user_profile/update', 'UserProfileController@update')->name('adminUserProfileUpdate');
    Route::get('/change_password', 'UserProfileController@changePassword')->name('adminChangePassword');
    Route::post('/change_password/update', 'UserProfileController@updatePassword')->name('adminUpdatePassword');
    //Admin Role Manager
    Route::get('/admin_roles', 'ManageRoleController@index')->name('adminRoleManager');
    Route::get('/admin_roles/create', 'ManageRoleController@create')->name('adminRoleManagerCreate');
    Route::post('/admin_roles/create', 'ManageRoleController@store')->name('adminRoleManagerStore');
    Route::get('/admin_roles/update/{id}', 'ManageRoleController@edit')->name('adminRoleManagerEdit');
    Route::post('/admin_roles/update', 'ManageRoleController@update')->name('adminRoleManagerUpdate');
    Route::get('/admin_roles/delete/{id}', 'ManageRoleController@delete')->name('adminRoleManagerDelete');
    Route::post('/admin_roles/publish', 'ManageRoleController@publish')->name('adminRoleManagerPublish');
    //Admin User Manager
    Route::get('/admin_users', 'ManageAdminUserController@index')->name('adminUserManager');
    Route::get('/admin_users/create', 'ManageAdminUserController@create')->name('adminUserManagerCreate');
    Route::post('/admin_users/create', 'ManageAdminUserController@store')->name('adminUserManagerStore');
    Route::get('/admin_users/update/{id}', 'ManageAdminUserController@edit')->name('adminUserManagerEdit');
    Route::post('/admin_users/update', 'ManageAdminUserController@update')->name('adminUserManagerUpdate');
    Route::get('/admin_users/delete/{id}', 'ManageAdminUserController@delete')->name('adminUserManagerDelete');
    Route::post('/admin_users/publish', 'ManageAdminUserController@publish')->name('adminUserManagerPublish');
    
   
    //Admin Location City
    Route::get('/locationcity', 'ManageAdminLocationCityController@index')->name('adminLocationCity');
    Route::get('/locationcity/create', 'ManageAdminLocationCityController@create')->name('adminLocationCityCreate');
    Route::post('/locationcity/create', 'ManageAdminLocationCityController@store')->name('adminLocationCityStore');
    Route::get('/locationcity/update/{id}', 'ManageAdminLocationCityController@edit')->name('adminLocationCityEdit');
    Route::post('/locationcity/update', 'ManageAdminLocationCityController@update')->name('adminLocationCityUpdate');
    Route::get('/locationcity/delete/{id}', 'ManageAdminLocationCityController@delete')->name('adminLocationCityDelete');
    Route::post('/locationcity/publish', 'ManageAdminLocationCityController@publish')->name('adminLocationCityPublish');
    
    //Admin Module Type
    Route::get('/moduletype', 'ManageModuleTypeController@index')->name('adminModuleType');
    Route::get('/moduletype/create', 'ManageModuleTypeController@create')->name('adminModuleTypeCreate');
    Route::post('/moduletype/create', 'ManageModuleTypeController@store')->name('adminModuleTypeStore');
    Route::get('/moduletype/update/{id}', 'ManageModuleTypeController@edit')->name('adminModuleTypeEdit');
    Route::post('/moduletype/update', 'ManageModuleTypeController@update')->name('adminModuleTypeUpdate');
    Route::get('/moduletype/delete/{id}', 'ManageModuleTypeController@delete')->name('adminModuleTypeDelete');
    Route::post('/moduletype/publish', 'ManageModuleTypeController@publish')->name('adminModuleTypePublish');
    
   
    //Admin Category
    Route::get('/category', 'ManageAdminCategoryController@index')->name('adminCategory');
    Route::get('/category/create', 'ManageAdminCategoryController@create')->name('adminCategoryCreate');
    Route::post('/category/create', 'ManageAdminCategoryController@store')->name('adminCategoryStore');
    Route::get('/category/update/{id}', 'ManageAdminCategoryController@edit')->name('adminCategoryEdit');
    Route::post('/category/update', 'ManageAdminCategoryController@update')->name('adminCategoryUpdate');
    Route::get('/category/delete/{id}', 'ManageAdminCategoryController@delete')->name('adminCategoryDelete');
    Route::post('/category/publish', 'ManageAdminCategoryController@publish')->name('adminCategoryPublish');

    //Admin Level
    Route::get('/level', 'ManageAdminLevelController@index')->name('adminLevel');
    Route::get('/level/create', 'ManageAdminLevelController@create')->name('adminLevelCreate');
    Route::post('/level/create', 'ManageAdminLevelController@store')->name('adminLevelStore');
    Route::get('/level/update/{id}', 'ManageAdminLevelController@edit')->name('adminLevelEdit');
    Route::post('/level/update', 'ManageAdminLevelController@update')->name('adminLevelUpdate');
    Route::get('/level/delete/{id}', 'ManageAdminLevelController@delete')->name('adminLevelDelete');
    Route::post('/level/publish', 'ManageAdminLevelController@publish')->name('adminLevelPublish');
    
    //Admin Markets
    Route::get('/markets', 'ManageAdminMarketsController@index')->name('adminMarkets');
    Route::get('/markets/create', 'ManageAdminMarketsController@create')->name('adminMarketsCreate');
    Route::post('/markets/create', 'ManageAdminMarketsController@store')->name('adminMarketsStore');
    Route::get('/markets/update/{id}', 'ManageAdminMarketsController@edit')->name('adminMarketsEdit');
    Route::post('/markets/update', 'ManageAdminMarketsController@update')->name('adminMarketsUpdate');
    Route::get('/markets/delete/{id}', 'ManageAdminMarketsController@delete')->name('adminMarketsDelete');
    Route::post('/markets/publish', 'ManageAdminMarketsController@publish')->name('adminMarketsPublish');
    
	 //Admin Courses
    Route::get('/courses', 'ManageAdminCoursesController@index')->name('adminCourses');
    Route::get('/courses/create', 'ManageAdminCoursesController@create')->name('adminCoursesCreate');
    Route::post('/courses/create', 'ManageAdminCoursesController@store')->name('adminCoursesStore');
    Route::get('/courses/update/{id}', 'ManageAdminCoursesController@edit')->name('adminCoursesEdit');
    Route::post('/courses/update', 'ManageAdminCoursesController@update')->name('adminCoursesUpdate');
    Route::get('/courses/delete/{id}', 'ManageAdminCoursesController@delete')->name('adminCoursesDelete');
    Route::post('/courses/publish', 'ManageAdminCoursesController@publish')->name('adminCoursesPublish');
	
	 //Admin CourseVideos
    Route::get('/coursevideos', 'ManageAdminCourseVideosController@index')->name('adminCourseVideos');
    Route::get('/coursevideos/create', 'ManageAdminCourseVideosController@create')->name('adminCourseVideosCreate');
    Route::post('/coursevideos/create', 'ManageAdminCourseVideosController@store')->name('adminCourseVideosStore');
    Route::get('/coursevideos/update/{id}', 'ManageAdminCourseVideosController@edit')->name('adminCourseVideosEdit');
    Route::post('/coursevideos/update', 'ManageAdminCourseVideosController@update')->name('adminCourseVideosUpdate');
    Route::get('/coursevideos/delete/{id}', 'ManageAdminCourseVideosController@delete')->name('adminCourseVideosDelete');
    Route::post('/coursevideos/publish', 'ManageAdminCourseVideosController@publish')->name('adminCourseVideosPublish');	
	
	 //Admin Dashboard Notification
    Route::get('/dashboardnotification', 'ManageAdminDashboardNotificationController@index')->name('adminDashboardNotification');
    Route::get('/dashboardnotification/create', 'ManageAdminDashboardNotificationController@create')->name('adminDashboardNotificationCreate');
    Route::post('/dashboardnotification/create', 'ManageAdminDashboardNotificationController@store')->name('adminDashboardNotificationStore');
    Route::get('/dashboardnotification/update/{id}', 'ManageAdminDashboardNotificationController@edit')->name('adminDashboardNotificationEdit');
    Route::post('/dashboardnotification/update', 'ManageAdminDashboardNotificationController@update')->name('adminDashboardNotificationUpdate');
    Route::get('/dashboardnotification/delete/{id}', 'ManageAdminDashboardNotificationController@delete')->name('adminDashboardNotificationDelete');
    Route::post('/dashboardnotification/publish', 'ManageAdminDashboardNotificationController@publish')->name('adminDashboardNotificationPublish');
    
    //Admin Notification
    Route::get('/notifications', 'ManageAdminNotificationsController@index')->name('adminNotifications');
    Route::get('/notifications/create', 'ManageAdminNotificationsController@create')->name('adminNotificationsCreate');
    Route::post('/notifications/create', 'ManageAdminNotificationsController@store')->name('adminNotificationsStore');
    //Route::get('/notifications/update/{id}', 'ManageAdminNotificationsController@edit')->name('adminNotificationsEdit');
    //Route::post('/notifications/update', 'ManageAdminNotificationsController@update')->name('adminNotificationsUpdate');
    //Route::get('/notifications/delete/{id}', 'ManageAdminNotificationsController@delete')->name('adminNotificationsDelete');
    //Route::post('/notifications/publish', 'ManageAdminNotificationsController@publish')->name('adminNotificationsPublish');
    
    
    //Admin Size
    Route::get('/size', 'ManageAdminSizeController@index')->name('adminSize');
    Route::get('/size/create', 'ManageAdminSizeController@create')->name('adminSizeCreate');
    Route::post('/size/create', 'ManageAdminSizeController@store')->name('adminSizeStore');
    Route::get('/size/update/{id}', 'ManageAdminSizeController@edit')->name('adminSizeEdit');
    Route::post('/size/update', 'ManageAdminSizeController@update')->name('adminSizeUpdate');
    Route::get('/size/delete/{id}', 'ManageAdminSizeController@delete')->name('adminSizeDelete');
    Route::post('/size/publish', 'ManageAdminSizeController@publish')->name('adminSizePublish');
    
    //Admin Gender
    Route::get('/gender', 'ManageAdminGenderController@index')->name('adminGender');
    Route::get('/gender/create', 'ManageAdminGenderController@create')->name('adminGenderCreate');
    Route::post('/gender/create', 'ManageAdminGenderController@store')->name('adminGenderStore');
    Route::get('/gender/update/{id}', 'ManageAdminGenderController@edit')->name('adminGenderEdit');
    Route::post('/gender/update', 'ManageAdminGenderController@update')->name('adminGenderUpdate');
    Route::get('/gender/delete/{id}', 'ManageAdminGenderController@delete')->name('adminGenderDelete');
    Route::post('/gender/publish', 'ManageAdminGenderController@publish')->name('adminGenderPublish');
    
     //Admin Color
    Route::get('/color', 'ManageAdminColorController@index')->name('adminColor');
    Route::get('/color/create', 'ManageAdminColorController@create')->name('adminColorCreate');
    Route::post('/color/create', 'ManageAdminColorController@store')->name('adminColorStore');
    Route::get('/color/update/{id}', 'ManageAdminColorController@edit')->name('adminColorEdit');
    Route::post('/color/update', 'ManageAdminColorController@update')->name('adminColorUpdate');
    Route::get('/color/delete/{id}', 'ManageAdminColorController@delete')->name('adminColorDelete');
    Route::post('/color/publish', 'ManageAdminColorController@publish')->name('adminColorPublish');
    
     //Admin Conditions
    Route::get('/condition', 'ManageAdminConditionController@index')->name('adminCondition');
    Route::get('/condition/create', 'ManageAdminConditionController@create')->name('adminConditionCreate');
    Route::post('/condition/create', 'ManageAdminConditionController@store')->name('adminConditionStore');
    Route::get('/condition/update/{id}', 'ManageAdminConditionController@edit')->name('adminConditionEdit');
    Route::post('/condition/update', 'ManageAdminConditionController@update')->name('adminConditionUpdate');
    Route::get('/condition/delete/{id}', 'ManageAdminConditionController@delete')->name('adminConditionDelete');
    Route::post('/condition/publish', 'ManageAdminConditionController@publish')->name('adminConditionPublish');
    
     //Admin CMS Pages
    Route::get('/pages', 'ManageAdminPagesController@index')->name('adminPages');
    Route::get('/pages/create', 'ManageAdminPagesController@create')->name('adminPagesCreate');
    Route::post('/pages/create', 'ManageAdminPagesController@store')->name('adminPagesStore');
    Route::get('/pages/update/{id}', 'ManageAdminPagesController@edit')->name('adminPagesEdit');
    Route::post('/pages/update', 'ManageAdminPagesController@update')->name('adminPagesUpdate');
    Route::get('/pages/delete/{id}', 'ManageAdminPagesController@delete')->name('adminPagesDelete');
    Route::post('/pages/publish', 'ManageAdminPagesController@publish')->name('adminPagesPublish');
    
	// Mobile API User Manager
    Route::get('/users', 'ManageUserController@index')->name('usersManager');
    // Route::get('/users/create', 'ManageUserController@create')->name('usersCreate');
    // Route::post('/users/create', 'ManageUserController@store')->name('usersStore');
    // Route::get('/users/update/{id}', 'ManageUserController@edit')->name('usersEdit');
    // Route::post('/users/update', 'ManageUserController@update')->name('usersUpdate');
    // Route::get('/users/delete/{id}', 'ManageUserController@delete')->name('usersDelete');
    // Route::post('/users/publish', 'ManageUserController@publish')->name('usersPublish');
	Route::get('/users/paymenthistory/{id}', 'ManageUserController@paymenthistory')->name('usersPaymentHistory');
	
	//Admin Advisory Notification 
    Route::get('/advisorynotification', 'AdvisoryNotificationController@index')->name('adminAdvisoryNotification');
    Route::get('/advisorynotification/create', 'AdvisoryNotificationController@create')->name('adminAdvisoryNotificationCreate');
    Route::post('/advisorynotification/create', 'AdvisoryNotificationController@store')->name('adminAdvisoryNotificationStore');
    Route::get('/advisorynotification/update/{id}', 'AdvisoryNotificationController@changerequest')->name('adminAdvisoryNotificationChangeAction');
    Route::post('/advisorynotification/update', 'AdvisoryNotificationController@update')->name('adminAdvisoryNotificationChangeActionUpdate');
    // Route::get('/advisorynotification/update/{id}', 'AdvisoryNotificationController@edit')->name('adminAdvisoryNotificationEdit');
  //  Route::post('/advisorynotification/update', 'AdvisoryNotificationController@update')->name('adminAdvisoryNotificationUpdate');
   // Route::get('/advisorynotification/delete/{id}', 'AdvisoryNotificationController@delete')->name('adminAdvisoryNotificationDelete');
    Route::post('/advisorynotification/publish', 'AdvisoryNotificationController@publish')->name('adminAdvisoryNotificationPublish');
	
    Route::post('/advisorynotification/advisorycourses', 'AdvisoryNotificationController@advisorycoursesbymarketid')->name('advisorycourses');    
    
	Route::post('/advisorynotification/advisorycoursesreportgenerate', 'AdvisoryNotificationController@advisorycoursesreportgenerate')->name('advisorycoursesreportgenerate'); 
	Route::post('/advisorynotification/getadvisoryreportdate', 'AdvisoryNotificationController@getadvisoryreportdate')->name('getadvisoryreportdate');
	Route::post('/getcoursesdetails', 'ManageAdminCoursesController@getCoursesDetails')->name('getCoursesDetails');
});
//Routes check with login
Route::group(['middleware' => 'IsAdmin', 'namespace' => 'Admin'], function() {
    //Logout
    Route::post('/logout', 'Auth\LoginController@logout')->name('adminLogout');
    //Set records
    Route::get('/set_records/{record}', 'SystemAdminController@setRecords')->name('adminSetRecords');
     Route::get('/resetpassword/{id}', 'ManageAdminUserController@resetpassword');
    Route::get('/', function() {
        return redirect()->route('adminHome');
    });
});
