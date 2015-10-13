<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
	/**
     * Redirect to Dashboard
     * 
     * @return  response
     */
    public function index()
    {  
    	return action('DashboardController@index');  
    }

    /**
     * Display Login Page
     * 
     * @return  response
     */
    public function getlogin()
    {
    	return view('public.auth.login', [
    		'title' => 'Login'
    	]);
    }

    /**
     * Handle user login request
     *
     * @return  response
     */
    public function postlogin(LoginRequest $request)
    {
        $remember = ($request->has('remember_me'))? true: false;
        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        // Check to see if user authenticates
        if ($this->auth->attempt($credentials, $remember))
        {   
            // Check if authenticated user is suspended
            if($this->auth->user()->account_status !== 1)
            {   
                $this->logger->newUserLog('Suspended user attemped to login', false);
                
                // User is suspended so we logout them out and set authentication error
                $this->auth->logout();
                $invalidRequest = [ \Config::get('messages.accountSuspended') ];
            }

            // Redirect to dashboard if user authenticates and is not suspended
            if(!isset($invalidRequest) && $this->auth->check())
            {
                $this->logger->newUserLog('User successfully logged in.');
                return redirect('/');
            }
        }
        
        // Authentication fails (wrong username or password)
        if(!isset($invalidRequest))
            $invalidRequest = [ \Config::get('messages.invalidLogin') ];
        
        // Redirect back to login page with authentication errors
        $this->request->session()->flash('invalidRequest', $invalidRequest);
        $this->logger->newSystemLog('Failed login attempt from ' . $this->request->ip(), false);
        return redirect()->back()->withInput();
    }

    /**
     * Dispay Forgot Password Page
     * 
     * @return  response
     */
    public function getForgotPassword()
    {
    	return view('public.forgot-password', ['title' => 'Forgot Password']);
    }

    /**
     * Handle Forgot Password Request
     * 
     * @return  response
     */
    public function postForgotPassword()
    {
    	// handle forgot password request
    }

    /**
     * Handle Logout Request
     *
     * @return  void
     */
    public function logout()
    {
        if($this->request->has('session_timeout') && $this->request->get('session_timeout') == 1)
        {
            $this->auth->logout();    
            return redirect()->action('AuthController@getIndex');
        }

        $this->logger->newUserLog('User successfully logged out.');
        $this->auth->logout();
	   	return redirect()->action('AuthController@getIndex');
    }
}
