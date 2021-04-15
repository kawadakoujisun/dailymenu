<?php

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

//Route::get('/', 'SampleObjectsController@index');    // 上書き

Route::resource('sample_objects', 'SampleObjectsController', ['only' => ['index', 'store']]);

Route::get('/', 'ContentsController@index');    // 上書き

Route::get   ('contents'                                   , 'ContentsController@index'                       )->name('contents.index'                       );
Route::get   ('contents/ranking/request-count'             , 'ContentsController@getRankingOfRequestCount'    )->name('contents.GetRankingOfRequestCount'    );
Route::get   ('contents/ranking/appearance-count'          , 'ContentsController@getRankingOfAppearanceCount' )->name('contents.GetRankingOfAppearanceCount' );
Route::get   ('contents/ranking/recent-appearance'         , 'ContentsController@getRankingOfRecentAppearance')->name('contents.GetRankingOfRecentAppearance');
Route::post  ('contents/ranking'                           , 'ContentsController@postRanking'                 )->name('contents.PostRanking'                 );
Route::get   ('contents/request-dish/{dish_id}'            , 'ContentsController@RequestDish'                 )->name('contents.RequestDish'                 );

Route::get   ('management/base'                            , 'ManagementBaseController@index'                 )->name('management.base.index'                );

Route::get   ('management/login'                           , 'Auth\LoginController@showLoginForm'             )->name('login'                                );
Route::post  ('management/login'                           , 'Auth\LoginController@login'                     )->name('login.post'                           );
Route::get   ('management/logout'                          , 'Auth\LoginController@logout'                    )->name('logout.get'                           );

Route::group(['middleware' => ['auth']], function () {

Route::get   ('management/dishes'                          , 'ManagementDishesController@index'               )->name('management.dishes.index'              );
Route::get   ('management/dishes/{id}/edit'                , 'ManagementDishesController@edit'                )->name('management.dishes.edit'               );
Route::put   ('management/dishes/{id}'                     , 'ManagementDishesController@update'              )->name('management.dishes.update'             );
Route::delete('management/dishes/{id}'                     , 'ManagementDishesController@destroy'             )->name('management.dishes.destroy'            );
Route::get   ('management/dishes/{id}/reset-request-count' , 'ManagementDishesController@ResetRequestCount'   )->name('management.dishes.ResetRequestCount'  );

Route::get   ('management/dates'                           , 'ManagementDatesController@index'                )->name('management.dates.index'               );
Route::get   ('management/dates/create-new-dish'           , 'ManagementDatesController@createNewDish'        )->name('management.dates.CreateNewDish'       );
Route::post  ('management/dates/store-new-dish'            , 'ManagementDatesController@storeNewDish'         )->name('management.dates.StoreNewDish'        );
Route::get   ('management/dates/create-same-dish/{dish_id}', 'ManagementDatesController@createSameDish'       )->name('management.dates.CreateSameDish'      );
Route::post  ('management/dates/store-same-dish/{dish_id}' , 'ManagementDatesController@storeSameDish'        )->name('management.dates.StoreSameDish'       );
Route::delete('management/dates/{id}'                      , 'ManagementDatesController@destroy'              )->name('management.dates.destroy'             );

});