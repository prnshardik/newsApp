@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    City View
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
                <a href="{{ route('admin.city') }}">Cities</i></a>
            </li>
            <li class="breadcrumb-item">View</li>
        </ol>
    </div>
   <div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">City View</div>
                </div>
                <div class="ibox-body">
                    <form name="form" id="form" method="post">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="country_code">Country Name</label>
                                <select name="country_name" class="form-control" disabled>
                                    <option value="{{ $data->id }}">{{ $data->country_name }}</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="country_code">State Name</label>
                                <select name="state_name" class="form-control" disabled>
                                    <option value="{{ $data->id }}">{{ $data->state_name }}</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Plese Enter Name" value="{{ $data->name ?? '' }}" readonly>
                                <span class="kt-form__help error name"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.city') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

