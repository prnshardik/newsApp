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
                <a href="{{ route('user.profile') }}">Profile</i></a>
            </li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                            <img class="img-circle" src="{{ asset('backend/img/admin-avatar.png') }}"" />
                        </div>
                        <h5 class="font-strong m-b-10 m-t-10">{{$user->firstname}} {{$user->lastname}}</h5>
                        <?php
                            $role = 'Reporter';
                        ?>
                        <div class="m-b-20 text-muted">{{$role}}</div>
                        
                        <div>
                            <a href="{{url('user/profile-edit',Auth::user()->id)}}">
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
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                                <ul class="nav nav-tabs tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#tab-1" data-toggle="tab"><i class="ti-settings"></i> Profile</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab-1">
                                        <form action="javascript:void(0)">
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label>Unique ID</label>
                                                    <input class="form-control" value="{{$user->unique_id ?? ''}}" type="text" placeholder="First Name" disabled>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label>Mobile Number</label>
                                                    <input class="form-control" value="{{$user->phone_no ?? ''}}" type="text" placeholder="First Name" disabled>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Address</label>
                                                    <textarea name="address" class="form-control" disabled>{{ $user->address ?? '' }}</textarea>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Country</label>
                                                    <input class="form-control" value="{{ $user->country_name }}" type="text" placeholder="text" disabled>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>State</label>
                                                    <input class="form-control" value="{{ $user->state_name }}" type="text" placeholder="text" disabled>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label>City</label>
                                                    <input class="form-control" value="{{ $user->city_name }}" type="text" placeholder="text" disabled>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection