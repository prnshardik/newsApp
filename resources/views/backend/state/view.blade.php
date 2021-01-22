@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    View Country
@endsection

@section('styles')
@endsection

@section('content')
   <div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">View Country</div>
                </div>
                <div class="ibox-body">
                    <form name="form" id="form" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Plese Enter Name" value="{{ $state->name ?? '' }}" readonly>
                                <span class="kt-form__help error name"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="country_code">Country Name</label>
                                <select name="country_name" class="form-control" disabled>
                                    <option value="{{$state->id}}">{{$state->country_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.state') }}">
                                <button type="button" class="btn btn-secondary">Back</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

