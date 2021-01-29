@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Taluka View
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
                <a href="{{ route('admin.taluka') }}"><span class="text-dark font-weight-bold">Talukas</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">View</span></li>
        </ol>
    </div>
   <div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Taluka View</div>
                </div>
                <div class="ibox-body">
                    <form name="form" id="form" method="post">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="district_id">District</label>
                                <select name="district_id" id="district_id" class="form-control" disabled>
                                    <option value="" hidden>Select Disctict</option>
                                    @if(isset($districts) && $districts->isNotEmpty())
                                        @foreach($districts as $row)
                                            <option value="{{ $row->id }}" @if(isset($data) && $data->district_id == $row->id) selected @endif>{{ $row->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="kt-form__help error district_id"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ $data->name ?? '' }}" disabled>
                                <span class="kt-form__help error name"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.taluka') }}" class="btn btn-secondary">Back</a>
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
