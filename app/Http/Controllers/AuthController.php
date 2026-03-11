<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
  protected $authService;

  public function __construct()
  {
    $this->authService = new AuthService();
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8|confirmed',
    ]);

    $this->authService->register($request->all());

    return redirect()->route('login')->with('success', 'registration success');
  }

  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if ($this->authService->login($credentials)) {
      return redirect()->route('dashboard');
    }

    return back()->with('error', 'invalid credentials');
  }

  public function logout(Request $request)
  {
    $this->authService->logout($request);

    return redirect()->route('login');
  }

  public function showLogin()
  {
    return view('auth.login');
  }

  public function showRegister()
  {
    return view('auth.register');
  }
}
