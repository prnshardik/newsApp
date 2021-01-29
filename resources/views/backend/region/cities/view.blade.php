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
                <a href="{{ route('admin.dashboard') }}"><span class="text-dark font-weight-bold">Dashboard</span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.city') }}"><span class="text-dark font-weight-bold">Cities</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">View</span></li>
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
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ $data->name ?? '' }}" readonly>
                                <span class="kt-form__help error name"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="pincode">Pincode</label>
                                <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ $data->pincode ?? '' }}" readonly>
                                <span class="kt-form__help error pincode"></span>
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

@section('scripts')
@endsection
