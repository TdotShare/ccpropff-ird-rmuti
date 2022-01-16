<?php

use Illuminate\Support\Facades\Route;

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

$backend = '/admin';

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['prefix' =>  '/auth'], function () {

    Route::get('/', function () {
        return view('auth.login');
    })->name('login_index_page');

    Route::post('/login', "AuthenticationController@actionLogin")->name('login_data');
    Route::get('/logout', "AuthenticationController@actionLogout")->name('logout_data');
    
});

Route::get('/', function () {
    return redirect()->route("dashboard_index_page");
});

Route::group(['prefix' =>  '/dashboard', 'middleware' => ['guest' , 'counter']], function () {
    Route::get('/', "DashboardController@actionIndex")->name('dashboard_index_page');
});


Route::group(['prefix' =>  '/profile', 'middleware' => ['guest' , 'counter']], function () {
    Route::get('/', "ProfileController@actionIndex")->name('profile_index_page');
});

Route::group(['prefix' =>  '/suggestion', 'middleware' => ['guest' , 'counter']], function () {
    Route::get('/', "SuggestionController@actionIndex")->name('suggestion_index_page');
    Route::get('/{id}', "SuggestionController@actionView")->name('suggestion_view_page');

    Route::get('/{id}/create', "SuggestionController@actionCreate")->name('suggestion_create_page');
    Route::get('/{id}/project/create', "SuggestionController@actionSubProject")->name('suggestion_subproject_page');
    Route::get('/delete/{id}', "SuggestionController@actionDelete")->name('suggestion_delete_data');
    Route::post('/create', "SuggestionController@actionCreate")->name('suggestion_create_data');
    Route::post('/project/create', "SuggestionController@actionSubProject")->name('suggestion_subproject_data');
});

Route::group(['prefix' =>  '/project', 'middleware' => ['guest' , 'counter']], function () {
    Route::get('/{id}', "ProjectController@actionView")->name('project_view_page');
    Route::get('/{id}/cores', "ProjectController@actionCoResearcher")->name('project_cores_page');


    Route::get('/{id}/preview', "OverviewController@actionPreview")->name('preview_view_page');

    Route::get('/{id}/files', "FilesController@actionIndex")->name('files_index_page');
    Route::post('/{id}/upload', "FilesController@actionUpload")->name('files_upload_data');

    Route::get('/{id}/fund', "FundController@actionIndex")->name('fund_index_page');
    Route::get('/{id}/publish', "PublishController@actionIndex")->name('publish_index_page');
    Route::get('/{id}/intellectual', "IntellectualController@actionIndex")->name('intellectual_index_page');



    Route::get('/{id}/overview', "OverviewController@actionIndex")->name('overview_index_data');

    
    Route::post('/cores/create', "ProjectController@actionCoResearcher")->name('project_cores_create_data');
    Route::get('/delete_cores/{id}', "ProjectController@actionDeleteCoResearcher")->name('project_cores_delete_data');
    Route::post('/update', "ProjectController@actionUpdateProject")->name('project_update_project_data');
});

Route::group(['prefix' =>  $backend . '/faculty', 'middleware' => ['guest' , 'admin' , 'counter']], function () {
    Route::get('/', "FacultyController@actionIndex")->name('faculty_index_page');
    Route::get('/create', "FacultyController@actionCreate")->name('faculty_create_page');
    Route::get('/update/{id}', "FacultyController@actionUpdate")->name('faculty_update_page');

    Route::get('/delete/{id}', "FacultyController@actionDelete")->name('faculty_delete_data');
    Route::post('/update', "FacultyController@actionUpdate")->name('faculty_update_data');
    Route::post('/create', "FacultyController@actionCreate")->name('faculty_create_data');
});

Route::group(['prefix' =>  $backend . '/roadmaps', 'middleware' => ['guest' , 'admin' , 'counter']], function () {
    Route::get('/', "RoadmapsController@actionIndex")->name('roadmaps_index_page');
    Route::get('/create', "RoadmapsController@actionCreate")->name('roadmaps_create_page');
    Route::get('/update/{id}', "RoadmapsController@actionUpdate")->name('roadmaps_update_page');

    Route::get('/delete/{id}', "RoadmapsController@actionDelete")->name('roadmaps_delete_data');
    Route::post('/update', "RoadmapsController@actionUpdate")->name('roadmaps_update_data');
    Route::post('/create', "RoadmapsController@actionCreate")->name('roadmaps_create_data');
});

Route::group(['prefix' =>  $backend . '/indicators', 'middleware' => ['guest' , 'admin' , 'counter']], function () {
    Route::get('/{id}', "IndicatorsController@actionIndex")->name('indicators_index_page');
    Route::get('/{id}/create', "IndicatorsController@actionCreate")->name('indicators_create_page');
    Route::get('/update/{id}', "IndicatorsController@actionUpdate")->name('indicators_update_page');

    Route::get('/delete/{id}', "IndicatorsController@actionDelete")->name('indicators_delete_data');
    Route::post('/update', "IndicatorsController@actionUpdate")->name('indicators_update_data');
    Route::post('/create', "IndicatorsController@actionCreate")->name('indicators_create_data');
});

Route::group(['prefix' =>  $backend . '/topic', 'middleware' => ['guest' , 'admin' , 'counter']], function () {
    Route::get('/', "TopicController@actionIndex")->name('topic_index_page');
    Route::get('/create', "TopicController@actionCreate")->name('topic_create_page');
    Route::get('/update/{id}', "TopicController@actionUpdate")->name('topic_update_page');
    Route::get('/delete/{id}', "TopicController@actionDelete")->name('topic_delete_data');
    Route::post('/create', "TopicController@actionCreate")->name('topic_create_data');
    Route::post('/update', "TopicController@actionUpdate")->name('topic_update_data');
});




Route::group(['prefix' =>  $backend . '/project', 'middleware' => ['guest' , 'admin' , 'counter']], function () {
    Route::get('/{id}', "CheckedController@actionIndex")->name('checked_index_page');
    Route::get('/round/{id}', "CheckedController@actionRoundIndex")->name('checked_round_index_page');
    Route::post('/round/update', "CheckedController@actionRoundUpdate")->name('checked_round_update_data');
    Route::get('/view/{id}', "CheckedController@actionView")->name('checked_view_page');

    Route::get('/excel/{id}', "CheckedController@actionGenerateExcel")->name('checked_genexcel_data');
    Route::get('/excel_fund_all/{id}', "CheckedController@actionGenerateExcelFundAll")->name('checked_genexcel_fund_all_data');
    Route::get('/excel_intell_all/{id}', "CheckedController@actionGenerateExcelIntellAll")->name('checked_genexcel_intell_all_data');

    Route::get('/excelfund/{id}', "CheckedController@actionGenerateExcelFund")->name('checked_genexcel_fund_data');
    Route::get('/excelart/{id}', "CheckedController@actionGenerateExcelArticle")->name('checked_genexcel_article_data');
    Route::get('/excelconference/{id}', "CheckedController@actionGenerateExcelConference")->name('checked_genexcel_conference_data');
});


//////////////////////////

Route::group(['prefix' =>  '/fund', 'middleware' => ['guest' , 'counter']], function () {
    Route::post('/create', "FundController@actionCreate")->name('fund_create_data');
    Route::get('/delete/{id}', "FundController@actionDelete")->name('fund_delete_data');
});

Route::group(['prefix' =>  '/publish', 'middleware' => ['guest' , 'counter']], function () {
    Route::post('/article_create', "PublishController@actionCreateArticle")->name('publish_create_article_data');
    Route::get('/article_delete/{ptmain_id}/{article_id}', "PublishController@actionDeleteArticle")->name('publish_delete_article_data');

    Route::post('/conference_create', "PublishController@actionCreateConference")->name('publish_create_conference_data');
    Route::get('/conference_delete/{ptmain_id}/{confer_id}', "PublishController@actionDeleteConference")->name('publish_delete_conference_data');
});

Route::group(['prefix' =>  '/intellectual', 'middleware' => ['guest' , 'counter']], function () {
    Route::post('/create', "IntellectualController@actionCreate")->name('intellectual_create_data');
    Route::get('/delete/{ptmain_id}/{intelip_id}', "IntellectualController@actionDelete")->name('intellectual_delete_data');
});