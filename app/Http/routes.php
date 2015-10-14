<?php

// Backend UI for Organizations (incl. client portal)
Route::group(['domain' => '{organization}.stryve.io', 'middleware' => 'org.exists'], function()
{
	// AUTHENTICATION ROUTES
	Route::group(['prefix' => 'auth', 'as' => 'auth::'], function()
	{
		Route::get('agent-login', ['as' => 'agent-login', 'uses' => 'AuthController@getAgentLogin']);
		Route::get('client-login', ['as' => 'client-login', 'uses' => 'AuthController@getClientLogin']);
		Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
		Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword']);
	});

	// CLIENT PORT
	Route::group(['prefix' => 'client', 'as' => 'client::', 'middleware' => 'auth.client'], function()
	{	
		// Route name: "client::dasboard"
		Route::get('/', ['as' => 'dashboard', 'uses' => 'ClientDashboardController@index']);	

		Route::resource('dashboard', 'ClientDashboardController');
		Route::resource('tickets', 'ClientTicketsController');
	});

	// AGENT PORTAL
	Route::group(['prefix' => 'agent', 'as' => 'agent::', 'middleware' => 'auth.agent'], function()
	{
		// Route name: "agent::dasboard"
		Route::get('/', ['as' => 'dashboard', 'uses' => 'AgentDashboardController@index']);

		Route::resource('dashboard', 'AgentDashboardController');
		Route::resource('tickets', 'AgentTicketsController');
	});
});