<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
  protected $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function register(array $data)
  {
    return $this->userRepository->create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => $data['password'],
      'role' => 'user'
    ]);
  }

  public function login(array $credentials)
  {
    return Auth::attempt($credentials);
  }

  public function logout($request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();
  }
}
