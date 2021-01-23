@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Reporter View
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
                <a href="{{ route('admin.reporter') }}">Reporter</i></a>
            </li>
            <li class="breadcrumb-item">View</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporter View</div>
                    </div>
                    <div class="ibox-body">
                        <form name="form" id="form" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                
                                <div class="form-group col-sm-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" placeholder="Plese enter name" value="{{ $data->name }}" disabled>
                                    <span class="kt-form__help error name"></span>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="unique_id">Unique ID</label>
                                    <input type="text" class="form-control" placeholder="Plese enter Unique ID" value="{{ $data->unique_id }}" disabled>
                                    <span class="kt-form__help error unique_id"></span>
                                </div>


                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" placeholder="Please Enter Address" disabled>{{ $data->address }}</textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="phone_no">Mobile Number</label>
                                    <input type="text" class="form-control" placeholder="Plese enter country code" value="{{ $data->phone_no }}" disabled>
                                    <span class="kt-form__help error phone_no"></span>
                                </div>


                                <div class="form-group col-sm-6">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" placeholder="Plese enter Email" value="{{ $data->email }}" disabled>
                                    <span class="kt-form__help error email"></span>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="country_id">Country</label>
                                    <select  class="form-control" disabled>
                                            <option value="">{{$data->country_name}}</option>
                                    </select>
                                    <span class="kt-form__help error country_id"></span>
                                </div>


                                <div class="form-group col-sm-6">
                                    <label for="state_id">State</label>
                                    <select class="form-control" disabled>
                                        <option value="">{{$data->state_name}}</option>
                                    </select>
                                    <span class="kt-form__help error state_id"></span>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control" disabled>
                                        <option value="" hidden>{{$data->city_name}}</option>
                                    </select>
                                    <span class="kt-form__help error city_id"></span>
                                </div>



                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_start_no">Receipt Book Number</label>
                                    <input type="text"  class="form-control" value="{{ $data->receipt_book_start_no }}" placeholder="Please Enter Receipt Book Start No." disabled>
                                    <span class="kt-form__help error receipt_book_start_no"></span>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_end_no">&nbsp;</label>
                                    <input type="text" class="form-control" value="{{ $data->receipt_book_end_no }}" placeholder="Please Enter Receipt Book End No." disabled>
                                    <span class="kt-form__help error receipt_book_end_no"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.reporter') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
