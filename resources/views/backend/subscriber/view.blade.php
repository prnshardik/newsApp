@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscriber View
@endsection

@section('styles')
@endsection

@section('content')
    {{-- <div class="page-heading mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><span class="text-dark font-weight-bold">Dashboard</span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.subscriber') }}"><span class="text-dark font-weight-bold">Subscribers</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">View</span></li>
        </ol>
    </div> --}}
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-body">
                        <form name="form" id="form" method="post">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="receipt_no">Receipt No</label>
                                    <input type="text" name="receipt_no" id="receipt_no" class="form-control" placeholder="Plese enter receipt_no" value="{{ $data->receipt_no ?? '' }}" disabled>
                                    <span class="kt-form__help error receipt_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="magazine">Magazine</label>
                                    <div class="m-b-10">
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="shixan_sudha" @if(isset($data) && $data->magazine == 'shixan_sudha') checked @endif disabled>
                                            <span class="input-span"></span>Shixan Sudha
                                        </label>
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="arogya_sudha" @if(isset($data) && $data->magazine == 'arogya_sudha') checked @endif disabled>
                                            <span class="input-span"></span>Arogya Sudha
                                        </label>
                                    </div>
                                    <span class="kt-form__help error magazine"></span>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Subscriber View</div>
                    </div>
                    <div class="ibox-body">
                        <form name="form" id="form" method="post">
                            <div class="row">
                                {{-- <div class="form-group col-sm-6">
                                    <label for="receipt_no">Receipt No</label>
                                    <input type="text" name="receipt_no" id="receipt_no" class="form-control" placeholder="Plese enter receipt_no" value="{{ $data->receipt_no ?? '' }}" disabled>
                                    <span class="kt-form__help error receipt_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="magazine">Magazine</label>
                                    <div class="m-b-10">
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="shixan_sudha" @if(isset($data) && $data->magazine == 'shixan_sudha') checked @endif disabled>
                                            <span class="input-span"></span>Shixan Sudha
                                        </label>
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="arogya_sudha" @if(isset($data) && $data->magazine == 'arogya_sudha') checked @endif disabled>
                                            <span class="input-span"></span>Arogya Sudha
                                        </label>
                                    </div>
                                    <span class="kt-form__help error magazine"></span>
                                </div> --}}
                                <div class="form-group col-sm-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Plese enter firstname" value="{{ $data->firstname ?? '' }}" disabled>
                                    <span class="kt-form__help error firstname"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Plese enter lastname" value="{{ $data->lastname ?? '' }}" disabled>
                                    <span class="kt-form__help error lastname"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Plese enter email" value="{{ $data->email ?? '' }}" disabled>
                                    <span class="kt-form__help error email"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="phone">Phone No</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Plese enter phone no" value="{{ $data->phone ?? '' }}" disabled>
                                    <span class="kt-form__help error phone"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Plese enter address" cols="30" rows="3" disabled>{{ $data->address ?? '' }}</textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-control" disabled>
                                        <option value="" hidden>Select District</option>
                                        @if(isset($districts) && $districts->isNotEmpty())
                                            @foreach($districts AS $row)
                                                <option value="{{ $row->id }}"  @if(isset($data) && $data->district_id == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error district_id"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="taluka_id">Taluka</label>
                                    <select name="taluka_id" id="taluka_id" class="form-control" disabled>
                                        <option value="" hidden>Select Taluka</option>
                                        @if(isset($talukas) && !empty($talukas))
                                            @foreach($talukas as $row)
                                                <option value="{{ $row['id'] }}" @if(isset($data) && $data->taluka_id == $row['id']) selected @endif>{{ $row['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error taluka_id"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control" disabled>
                                        <option value="" hidden>Select City</option>
                                        @if(isset($cities) && !empty($cities))
                                            @foreach($cities as $row)
                                                <option value="{{ $row['id'] }}" @if(isset($data) && $data->city_id == $row['id']) selected @endif>{{ $row['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error city_id"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ $data->pincode ?? '' }}" disabled>
                                    <span class="kt-form__help error pincode"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.subscriber') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
