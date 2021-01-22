@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    State View
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
                <a href="{{ route('admin.state') }}">States</i></a>
            </li>
            <li class="breadcrumb-item">View</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">State View</div>
                    </div>
                    <div class="ibox-body">
                        <form name="form" id="form" method="post">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Plese Enter Name" value="{{ $data->name ?? '' }}" readonly>
                                    <span class="kt-form__help error name"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="country_code">Country Name</label>
                                    <select name="country_name" class="form-control" disabled>
                                        <option value="{{ $data->id }}">{{ $data->country_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.state') }}" class="btn btn-secondary">Back</a>
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
