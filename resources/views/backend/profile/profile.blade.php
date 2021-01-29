@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Profile
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-heading mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.profile') }}">Profile</i></a>
            </li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                            <img src="{{ _user_profile() }}" alt="{{ _site_name() }}" class="img-circle" height="80px" width="80px" />
                        </div>
                        <h5 class="font-strong m-b-10 m-t-10">{{ $data->firstname }} {{ $data->lastname }}</h5>
                        <div class="m-b-20 text-muted">{{ _get_role_name(auth()->user()->role_id) }}</div>
                        <div>
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-info btn-rounded m-b-5">Edit Profile</a>
                            <a href="{{ url()->previous() }}" class="btn btn-default btn-rounded m-b-5">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
