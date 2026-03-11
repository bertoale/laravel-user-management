<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
  protected $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function getUsers()
  {
    return $this->userRepository->getAll();
  }

  public function createUser(array $data)
  {
    return $this->userRepository->create($data);
  }

  public function updateUser($id, array $data)
  {
    $user = $this->userRepository->find($id);

    return $this->userRepository->update($user, $data);
  }

  public function deleteUser($id)
  {
    $user = $this->userRepository->find($id);

    if ($user->id == auth()->id()) {
      return false;
    }

    return $this->userRepository->delete($user);
  }

  public function updateProfile(array $data)
  {
    $user = Auth::user();

    return $user->update($data);
  }
}
