@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Role View
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
                <a href="{{ route('admin.role') }}">Roles</i></a>
            </li>
            <li class="breadcrumb-item">View</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Role View</div>
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
                                    <label for="guard_name">Guard Name</label>
                                    <input type="text" name="guard_name" id="guard_name" class="form-control" placeholder="Plese enter guard name" value="{{ $data->guard_name ?? '' }}" readonly>
                                    <span class="kt-form__help error guard_name"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <a href="{{ route('admin.role') }}" class="btn btn-secondary">Back</a>
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
