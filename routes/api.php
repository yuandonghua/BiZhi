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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/redirect', function (){
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://localhost:8888/BiZhi/public/auth/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);
    return redirect('http://localhost:8888/BiZhi/public/oauth/authorize?' . $query);
});

Route::get('/refresh', function (Request $request){
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8888/BiZhi/public/oauth/token', [
        'form_params' => [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => '3',
            'client_secret' => 'mGLQZPyKIN4jhQJfX05t3jV2lMTfGvqXxyoTnOF3',
            'scope' => '',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

