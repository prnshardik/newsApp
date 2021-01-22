@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    State Edit
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
            <li class="breadcrumb-item">Edit</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">State Edit</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.city.update') }}" name="form" id="form" method="post">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="country_code">Country Name</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="" hidden>Selct Country</option>
                                        @foreach($country AS $row)
                                            <option value="{{ $row->id }}" <?= (isset($data->country_id) && $data->country_id == $row->id ? 'selected' : '')?>>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="kt-form__help error country_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="country_code">State Name</label>
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="" hidden>Selct State</option>
                                        <option value="{{ $data->state_id }}" selected>{{ $data->state_name }}</option>
                                    </select>
                                    <span class="kt-form__help error state_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Plese Enter Name" value="{{ $data->name ?? '' }}">
                                    <span class="kt-form__help error name"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.city') }}" class="btn btn-secondary">Cancel</a>
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
        $('#country_id').select2({
            multiple: false,
        });

        $('#state_id').select2({
            multiple: false,
        });
    </script>

     <script>
        $('#country_id').change(function(){
            var country_id = $(this).val();

            if(country_id.length > 0){
                $.ajax({
                    url : "{{ route('admin.city.get_state') }}",
                    type : "post",
                    data : {
                        _token: "{{ csrf_token() }}",
                        country_id: country_id,
                    },
                    success : function(response){
                        $('#state_id').html('');

                        if(response.code == 200){
                            $('#state_id').html(response.data);
                        }else{
                            $('#state_id').html('<option value="">select state</option>');
                        }
                    },
                    error: function(json){
                        $('#state_id').html('');
                        $('#state_id').html('<option value="">select state</option>');
                    }
                });
            }else{
                $('#state_id').html('<option>Select State</option>');
            }
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
