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
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                            <img class="img-circle" src="{{ asset('backend/img/admin-avatar.png') }}"" />
                        </div>
                        <h5 class="font-strong m-b-10 m-t-10">{{$user->firstname}} {{$user->lastname}}</h5>
                        <?php
                            if(Auth::user()->id == 1){
                                $role = 'Admin';
                            }else{
                                $role = 'Reporter';
                            }
                        ?>
                        <div class="m-b-20 text-muted">{{$role}}</div>
                        <div class="profile-social m-b-20">
                        </div>
                        <div>
                            <a href="{{url('admin/profile-edit',Auth::user()->id)}}">
                                <button class="btn btn-info btn-rounded m-b-5">
                                    Edit Profile
                                </button>
                            </a>
                            <a href="{{ url()->previous() }}">
                                <button class="btn btn-default btn-rounded m-b-5">Back</button>
                            </a>
                        </div>
                    </div>
                </div>        
            </div>    
        </div>        
    </div>
@endsection