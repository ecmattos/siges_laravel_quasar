<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['middleware' => 'cors'], function (Router $api) {
        $api->group(['prefix' => 'auth'], function (Router $api) {
            $api->post('/clients', 'App\Api\V1\Controllers\Auth\ClientsController@store')->name('clients.store');
            $api->post('/users/admin', 'App\Api\V1\Controllers\Auth\UsersController@admin_store')->name('users.admin_store');
            #api/auth/login
            $api->post('/login', 'App\Api\V1\Controllers\Auth\LoginController@login')->name('auth.login');

            $api->post('/recovery', 'App\Api\V1\Controllers\Auth\ForgotPasswordController@sendResetEmail');
            $api->post('/reset', 'App\Api\V1\Controllers\Auth\ResetPasswordController@resetPassword');

            $api->post('/logout', 'App\Api\V1\Controllers\Auth\LogoutController@logout');
            $api->post('/refresh', 'App\Api\V1\Controllers\Auth\RefreshController@refresh')->name('auth.refresh');
            $api->get('/me', 'App\Api\V1\Controllers\UserController@me');
        });

        $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
            $api->get('/protected', function() {
                return response()->json([
                    'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
                ]);
            });

            #api/refresh
            $api->get('/refresh', 'App\Api\V1\Controllers\Auth\RefreshController@refresh', ['middleware' => 'jwt.refresh', function (Router $api) {
                    return response()->json([
                        'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                    ]);
                }
            ]);
        });

        $api->get('/hello', function() {
            return response()->json([
                'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
            ]);
        });
    });
});
