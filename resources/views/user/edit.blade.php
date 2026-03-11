@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow-sm p-4" style="width: 450px;">
        <h3 class="text-center mb-4">Edit User</h3>

        {{-- Tampilkan error validation --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="user" @if(old('role', $user->role) == 'user') selected @endif>User</option>
                    <option value="admin" @if(old('role', $user->role) == 'admin') selected @endif>Admin</option>
                </select>
            </div>

            <button class="btn btn-primary w-100">Update User</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('users.index') }}">Back to Users List</a>
        </div>
    </div>
</div>
@endsection