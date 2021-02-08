@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Taluka Create
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
                <a href="{{ route('admin.taluka') }}"><span class="text-dark font-weight-bold">Talukas</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Create</span></li>
        </ol>
    </div> --}}
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Taluka Create</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.taluka.insert') }}" name="form" id="form" method="post">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="" hidden>Select Disctict</option>
                                        @if(isset($districts) && $districts->isNotEmpty())
                                            @foreach($districts as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error district_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ @old('name') }}">
                                    <span class="kt-form__help error name"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.taluka') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#district_id').select2({
                multiple: false,
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            var form = $('#form');
            $('.kt-form__help').html('');
            form.submit(function(e) {
                $('.help-block').html('');
                $('.m-form__help').html('');
                $.ajax({
                    url : form.attr('action'),
                    type : form.attr('method'),
                    data : form.serialize(),
                    dataType: 'json',
                    async:false,
                    success : function(json){
                        return true;
                    },
                    error: function(json){
                        if(json.status === 422) {
                            e.preventDefault();
                            var errors_ = json.responseJSON;
                            $('.kt-form__help').html('');
                            $.each(errors_.errors, function (key, value) {
                                $('.'+key).html(value);
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
