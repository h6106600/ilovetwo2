<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/DateData', 'DateDataController');
    $router->resource('/Push', 'PushController');
    $router->resource('/Invitation', 'InvitationController');
    $router->resource('/Respond', 'RespondController');
    $router->resource('/Restaurant', 'RestaurantController');
    $router->resource('/RestaurantDate', 'RestaurantDateController');
    $router->resource('/VideoDate', 'VideoDateController');
});
