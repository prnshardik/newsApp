@extends('backend.auth.app')

@section('meta')
@endsection

@section('title')
    Forget Password
@endsection

@section('page-styles')
@endsection

@section('styles')
@endsection

@section('content')
    <div class="content mt-5">
        <div class="brand">
            <a class="link" href="javascript:void(0);">{{ _site_name() }}</a>
        </div>

        <h2 class="login-title">Recover Password</h2>

        <p class="text-muted font-14 mt-2 text-center"> A email has been send to <b>{{ $mail }}</b>. Please check for an email click on the included link to reset your password. </p>
        <p class="text-center"><a href="{{ route('admin.login') }}" class="btn btn-primary mt-2">Login</a></p>
    </div>
@endsection

@section('page-scripts')
@endsection

@section('scripts')
@endsection
