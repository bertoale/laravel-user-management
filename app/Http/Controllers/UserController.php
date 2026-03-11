<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function userIndex()
    {
        $users = $this->userService->getUsers();
        return view('user.index', compact('users'));
    }

    public function createUser()
    {
        return view('user.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        $this->userService->createUser([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password,
        ]);

        return redirect()->route('users.index');
    }

    public function editUser($id)
    {
        $user = $this->userService->getUsers()->find($id);
        return view('user.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $this->userService->updateUser($id, [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return back()->with('success', 'User updated');
    }

    public function destroyUser($id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return back()->with('error', 'You cannot delete your own account');
        }

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function profileIndex()
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $this->userService->updateProfile($data);

        return back()->with('success', 'Profile updated');
    }
}
