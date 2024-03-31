<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            // Authentication was successful
            return redirect()->intended('/invoices');
        } else {
            // Authentication failed
            return redirect()->to('/')->withErrors(trans('auth.failed'));
        }
    }
}
