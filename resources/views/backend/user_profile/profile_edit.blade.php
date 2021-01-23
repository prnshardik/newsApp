@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Profile Edit
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
                <a href="{{ route('admin.profile') }}">Profile</i></a>
            </li>
            <li class="breadcrumb-item">Edit</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">profile Edit</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('user.profile_update') }}" name="form" id="form" method="post">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="id" value="{{ $data->id ??'' }}">

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Plese enter firstname" value="{{ $data->firstname ?? '' }}">
                                    <span class="kt-form__help error firstname"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Plese enter lastname" value="{{ $data->lastname ?? '' }}">
                                    <span class="kt-form__help error lastname"></span>
                                </div>


                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" placeholder="Address."> {{ $data->address }} </textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="phone_no">Mobile Number</label>
                                    <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Plese enter phone_no" value="{{ $data->phone_no ?? '' }}">
                                    <span class="kt-form__help error phone_no"></span>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="country_id">Country</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="" hidden>Select Country</option>
                                        @if(isset($countries) && $countries->isNotEmpty())
                                            @foreach($countries AS $row)
                                                <option value="{{ $row->id }}" @if(isset($data) && $data->country_id == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error country_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="state_id">State</label>
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="" hidden>Select State</option>
                                        @if(isset($states) && !empty($states))
                                            @foreach($states as $row)
                                                <option value="{{ $row->id }}" @if(isset($data) && $data->state_id == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error state_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="" hidden>Select City</option>
                                        @if(isset($cities) && !empty($cities))
                                            @foreach($cities as $row)
                                                <option value="{{ $row->id }}" @if(isset($data) && $data->city_id == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error city_id"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
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
            $("#phone_no").keypress(function(e){
                var keyCode = e.keyCode || e.which;
                var $this = $(this);
                //Regex for Valid Characters i.e. Numbers.
                var regex = new RegExp("^[0-9\b]+$");

                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                // for 10 digit number only
                if ($this.val().length > 9) {
                    e.preventDefault();
                    return false;
                }
                if (e.charCode < 54 && e.charCode > 47) {
                    if ($this.val().length == 0) {
                        e.preventDefault();
                        return false;
                    } else {
                        return true;
                    }
                }
                if (regex.test(str)) {
                    return true;
                }
                e.preventDefault();
                return false;
            });

            $('#country_id').select2({
                multiple: false,
            });

            $('#state_id').select2({
                multiple: false,
            });

            $('#city_id').select2({
                multiple: false,
            });

            $('#country_id').change(function(){
                var country_id = $(this).val();

                if(country_id.length > 0){
                    $.ajax({
                        url : "{{ route('admin.city.get_state') }}",
                        type : "post",
                        data : {
                            _token: "{{ csrf_token() }}",
                            country_id: country_id
                        },
                        success : function(response){
                            $('#state_id').html('');

                            if(response.code == 200){
                                $('#state_id').html(response.data);
                                $('#city_id').html('<option value="">select City</option>');
                            }else{
                                $('#state_id').html('<option value="">select State</option>');
                                $('#city_id').html('<option value="">select City</option>');
                            }
                        },
                        error: function(json){
                            $('#state_id').html('');
                            $('#state_id').html('<option value="">select State</option>');
                            $('#city_id').html('');
                            $('#city_id').html('<option value="">select City</option>');
                        }
                    });
                }else{
                    $('#state_id').html('<option>Select State</option>');
                    $('#city_id').html('<option>Select City</option>');
                }
            });

            $('#state_id').change(function(){
                var state_id = $(this).val();
                var country_id = $("#country_id option:selected").val();

                if(state_id.length > 0){
                    $.ajax({
                        url : "{{ route('admin.city.get_city') }}",
                        type : "post",
                        data : {
                            _token: "{{ csrf_token() }}",
                            state_id: state_id,
                            country_id: country_id
                        },
                        success : function(response){
                            $('#city_id').html('');

                            if(response.code == 200){
                                $('#city_id').html(response.data);
                            }else{
                                $('#city_id').html('<option value="">select City</option>');
                            }
                        },
                        error: function(json){
                            $('#city_id').html('');
                            $('#city_id').html('<option value="">select City</option>');
                        }
                    });
                }else{
                    $('#city_id').html('<option>Select City</option>');
                }
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

