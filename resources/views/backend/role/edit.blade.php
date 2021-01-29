@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Role Edit
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
                <a href="{{ route('admin.role') }}"><span class="text-dark font-weight-bold">Roles</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Edit</span></li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Role Edit</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.role.update') }}" name="form" id="form" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $data->id }}">

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ $data->name ?? '' }}">
                                    <span class="kt-form__help error name"></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="form-group">
                                    <strong>Permissions:</strong>
                                    <div class="row">
                                        @foreach($permissions as $value)
                                            <div class="col-sm-3">
                                                <label class="ui-checkbox ui-checkbox-success mt-2" for="checkbox-{{ $value->id }}">
                                                    <input type="checkbox" name="permissions[]" id="checkbox-{{ $value->id }}" value="{{ $value->id }}" <?php if(in_array($value->id, $role_permissions)){ echo 'checked'; } ?>>
                                                    <span class="input-span"></span>{{ $value->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.role') }}" class="btn btn-secondary">Cancel</a>
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
