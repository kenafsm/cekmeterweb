@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Ubah Password')

@section('main-content')

<div class="container-fluid">
    <h1 class="h3 mb-0 text-gray-800">Ubah Password</h1>
    @if($errors->any())
    {!! implode('', $errors->all('<div class="alert alert-danger mt-3">:message</div>')) !!}
    @endif
    @if(Session::get('error') && Session::get('error') != null)
    <div class="alert alert-danger mt-3">{{ Session::get('error') }}</div>
    @php
    Session::put('error', null)
    @endphp
    @endif
    @if(Session::get('success') && Session::get('success') != null)
    <div class="alert alert-success mt-3">{{ Session::get('success') }}</div>
    @php
    Session::put('success', null)
    @endphp
    @endif
    <form class="p-3" action="{{ route('profile.ubahPassword') }}" method="post">
        @csrf
        <fieldset>
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Lama</label>
                <input type="password" class="form-control" id="current_password" name="current_password">
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
            </div>
        </fieldset>
        <button type="submit" class="btn btn-primary">Ubah Password</button>
    </form>
</div>

@endsection
