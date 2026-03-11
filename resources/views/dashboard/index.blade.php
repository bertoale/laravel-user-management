@extends('layouts.app')

@section('content')

<h3>Dashboard</h3>

<p>Welcome {{ auth()->user()->name }}</p>

@endsection