<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->group(['middleware' => 'cors'], function (Router $api) {

        $api->post('clients', 'App\\Api\\V1\\Controllers\\ClientsController@store')->name('clients.store');

        $api->group(['prefix' => 'auth'], function(Router $api) {
            $api->post('users/admin', 'App\\Api\\V1\\Controllers\\Auth\\UsersController@admin_store')->name('users.admin_store');
            $api->post('login', 'App\\Api\\V1\\Controllers\\Auth\\LoginController@login')->name('auth.login');
            $api->post('recovery', 'App\\Api\\V1\\Controllers\\Auth\\PasswordController@recovery')->name('auth.password_recovery');
            $api->post('reset', 'App\\Api\\V1\\Controllers\\Auth\\PasswordController@reset')->name('auth.password_reset');
            $api->post('refresh', 'App\\Api\\V1\\Controllers\\Auth\\RefreshController@refresh')->name('auth.refresh');
            $api->post('logout', 'App\\Api\\V1\\Controllers\\Auth\\LogoutController@logout')->name('auth.logout');
            
            $api->get('me', 'App\\Api\\V1\\Controllers\\Auth\\UsersController@me');
        });

        $api->get('refresh', ['middleware' => 'jwt.refresh', function() {
            return response()->json([
                'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);

        #$api->group(['middleware' => 'jwt.auth'], function(Router $api) {
            $api->group(['prefix' => 'customers'], function(Router $api) {
                $api->get('/', 'App\\Api\\V1\\Controllers\\CustomersController@index')->name('customers');
                $api->get('/create', 'App\\Api\\V1\\Controllers\\CustomersController@create')->name('customers.create');
                $api->get('/{id}/show', 'App\\Api\\V1\\Controllers\\CustomersController@show')->name('customers.show');
                $api->get('/{id}/edit', 'App\\Api\\V1\\Controllers\\CustomersController@edit')->name('customers.edit');
                $api->get('/{id}/destroy', 'App\\Api\\V1\\Controllers\\CustomersController@destroy')->name('customers.destroy');
                $api->put('/{id}/update', 'App\\Api\\V1\\Controllers\\CustomersController@update')->name('customers.update');
                $api->post('/', 'App\\Api\\V1\\Controllers\\CustomersController@store')->name('customers.store');
            });

            $api->get('protected', function() {
                return response()->json([
                    'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
                ]);
            });

            $api->get('hello', function() {
                return response()->json([
                    'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
                ]);
            });
        #});
    });
});
