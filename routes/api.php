<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout');
    Route::post('exis_user', 'AuthController@exis_user');


    Route::get('users', 'AuthController@users');
    Route::delete('delete/{id}', 'AuthController@delete');
    Route::get('getById/{id}', 'AuthController@getById');
    Route::put('update/{id}', 'AuthController@update');

    Route::group(['middleware' => 'auth:api'], function () {
        /*Route::get('user', 'AuthController@user');*/
        Route::get('logout', 'AuthController@logout');
        Route::get('me', 'AuthController@me');
        Route::post('user_rol', 'AuthController@user_rol');
    });
});

Route::prefix('role')->group(function () {
    Route::get('all', 'RolesController@index');
    Route::post('create', 'RolesController@create');
    Route::get('getById/{id}', 'RolesController@getById');
    Route::delete('delete/{id}', 'RolesController@delete');
    Route::put('update/{id}', 'RolesController@update');
});

Route::prefix('store')->group(function () {
    Route::get('all/{user_id}/{rol_name}', 'StoresController@index');
    Route::get('all', 'StoresController@all');
    Route::get('stores_by_user/{user_id}', 'StoresController@storesByUser');
    Route::post('create', 'StoresController@create');
    Route::get('getById/{id}', 'StoresController@getById');
    Route::delete('delete/{id}', 'StoresController@delete');
    Route::put('update/{id}', 'StoresController@update');
    Route::get('stores_employees_tax_percent_calculators/{user_id}', 'StoresController@storesEmployeesTaxPercentCalculators');
});

Route::prefix('week')->group(function () {
    Route::get('week_by_year/{year}', 'WeeksController@weekByYear');
});

Route::prefix('daily_revenue')->group(function () {
    Route::get('seven_days_week/{store_id}/{week_id}', 'DailyRevenuesController@sevenDaysWeek');
    Route::put('update_all_amt', 'DailyRevenuesController@updateAllAmt');
});

Route::prefix('invoice')->group(function () {
    Route::get('all/{store_id}/{week_id}', 'InvoicesController@all');
    Route::post('create', 'InvoicesController@create');
    Route::delete('delete/{id}', 'InvoicesController@delete');
});

Route::prefix('note')->group(function () {
    Route::get('all/{store_id}/{week_id}', 'NotesController@all');
    Route::put('update/{store_id}/{week_id}', 'NotesController@update');
});

Route::prefix('diff_projection_percent')->group(function () {
    Route::get('{store_id}/{week_id}/{year}', 'DiffProjectionsPercentController@diffProjectionPercent');
    Route::post('create', 'InvoicesController@create');
});

Route::prefix('weekly_projection_percent_costs')->group(function () {
    Route::get('target_cog/{store_id}/{week_id}', 'WeeklyProjectionPercentCostsController@targetCog');
    Route::put('update_target_cog/{store_id}/{week_id}', 'WeeklyProjectionPercentCostsController@updateTargetCog');
});

Route::prefix('weekly_projection_percent_revenue')->group(function () {
    Route::get('proj_weekly_revenue/{store_id}/{week_id}', 'WeeklyProjectionPercentCostsRevenuesController@projWeeklyRevenue');
    Route::put('update_proj_weekly_revenue/{store_id}/{week_id}', 'WeeklyProjectionPercentCostsRevenuesController@updateWeeklyProjection');
});

Route::prefix('master_overview_weekly')->group(function () {
    Route::get('master_overview_weekly_of_fresh/{store_id}/{year}', 'MasterOverviewWeeklyController@MasterOverviewWeeklyOfFresh');
    Route::get('weekly_projections/{store_id}/{year}', 'MasterOverviewWeeklyController@WeeklyProjections');
    Route::get('projection_col/{store_id}/{year}', 'MasterOverviewWeeklyController@ProjectionCol');
    Route::get('get_weekly_revenue/{store_id}/{week_nbr}/{year_reference_selected}', 'MasterOverviewWeeklyController@getDataStoreWeekYear');
    Route::get('scheduled_payroll_col/{store_id}/{week_id}', 'MasterOverviewWeeklyController@get_scheduled_payroll_col');
});

Route::prefix('employee')->group(function () {
    Route::get('all', 'EmployeesController@index');
    Route::post('create', 'EmployeesController@create');
    Route::put('update/{id}', 'EmployeesController@update');
    Route::get('getById/{id}', 'EmployeesController@getById');
});

Route::prefix('category')->group(function () {
    Route::get('all', 'CategoriesController@index');
});

Route::prefix('work_man_comp')->group(function () {
    Route::get('all', 'WorkMansCompController@index');
});

Route::prefix('schedule')->group(function () {
    Route::post('update_or_add', 'ScheduleController@updateoradd');
    Route::get('all/{store_id}/{week_id}', 'ScheduleController@schedule_week');
});

Route::prefix('target_percentage')->group(function () {
    Route::put('update_target_percentage/{store_id}/{week_id}', 'TargetPercentagesController@update_target_porcentage');
    Route::get('{store_id}/{week_id}', 'TargetPercentagesController@get_target');
});

Route::prefix('plan')->group(function () {
    Route::get('plans', 'PlansController@plans');
    Route::get('plansbyuser/{week_id}', 'PlansController@plansbyuser');
    Route::get('modulesbyuser/{week_id}', 'PlansController@modulesbyuser');
});

Route::prefix('company')->group(function () {
    Route::post('create', 'CompanyController@create');
    Route::post('valid_card', 'CompanyController@valid_card');
    Route::post('activate_company', 'CompanyController@activate_company');
});
