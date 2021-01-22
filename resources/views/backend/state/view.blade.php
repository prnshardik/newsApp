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
                                <input type="text" class="form-control" id="name" name="name" placeholder="Plese Enter Name" value="{{ $country->name ?? '' }}" readonly>
                                <span class="kt-form__help error name"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="country_code">Country Code</label>
                                <input type="text" class="form-control" id="country_code" name="country_code" placeholder="Plese Enter Country Code" value="{{ $country->country_code ?? '' }}" readonly>
                                <span class="kt-form__help error country_code"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.country') }}">
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

