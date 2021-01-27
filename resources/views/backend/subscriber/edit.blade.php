@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscriber Edit
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
                <a href="{{ route('admin.subscriber') }}">Subscribers</i></a>
            </li>
            <li class="breadcrumb-item">Edit</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Subscriber Edit</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.subscriber.update') }}" name="form" id="form" method="post">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="id" value="{{ $data->id }}">

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
                                    <label for="receipt_no">Receipt No</label>
                                    <input type="text" name="receipt_no_1" id="receipt_no_1" class="form-control" placeholder="Plese enter receipt_no" value="{{ $data->receipt_no ?? '' }}" disabled>
                                    <input type="hidden" name="receipt_no" id="receipt_no" value="{{ $data->receipt_no ?? '' }}">
                                    <span class="kt-form__help error receipt_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" placeholder="Plese enter description" value="{{ $data->description ?? '' }}">
                                    <span class="kt-form__help error description"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Plese enter email" value="{{ $data->email ?? '' }}">
                                    <span class="kt-form__help error email"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="phone">Phone No</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Plese enter phone no" value="{{ $data->phone ?? '' }}">
                                    <span class="kt-form__help error phone"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Plese enter address" value="{{ $data->address ?? '' }}">
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ $data->pincode ?? '' }}">
                                    <span class="kt-form__help error pincode"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="magazine">Magazine</label>
                                    <select name="magazine" id="magazine" class="form-control">
                                        <option value="" hidden>Select Magazine</option>
                                        <option value="shixan_sudha" @if(isset($data) && $data->magazine == 'shixan_sudha') selected @endif >Shixan Sudha</option>
                                        <option value="arogya_sudha" @if(isset($data) && $data->magazine == 'arogya_sudha') selected @endif >Arogya Sudha</option>
                                    </select>
                                    <span class="kt-form__help error magazine"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="country">Country</label>
                                    <select name="country" id="country" class="form-control">
                                        <option value="" hidden>Select Country</option>
                                        @if(isset($countries) && $countries->isNotEmpty())
                                            @foreach($countries AS $row)
                                                <option value="{{ $row->id }}" @if(isset($data) && $data->country == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error country"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="state">State</label>
                                    <select name="state" id="state" class="form-control">
                                        <option value="" hidden>Select State</option>
                                        @if(isset($states) && !empty($states))
                                            @foreach($states as $row)
                                                <option value="{{ $row->id }}" @if(isset($data) && $data->state == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error state"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="city">City</label>
                                    <select name="city" id="city" class="form-control">
                                        <option value="" hidden>Select City</option>
                                        @if(isset($cities) && !empty($cities))
                                            @foreach($cities as $row)
                                                <option value="{{ $row->id }}" @if(isset($data) && $data->city == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error city"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.subscriber') }}" class="btn btn-secondary">Cancel</a>
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
            $("#phone").keypress(function(e){
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


            $('#country').select2({
                multiple: false,
            });

            $('#state').select2({
                multiple: false,
            });

            $('#city').select2({
                multiple: false,
            });

            $('#country').change(function(){
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
                            $('#state').html('');

                            if(response.code == 200){
                                $('#state').html(response.data);
                                $('#city').html('<option value="">select City</option>');
                            }else{
                                $('#state').html('<option value="">select State</option>');
                                $('#city').html('<option value="">select City</option>');
                            }
                        },
                        error: function(json){
                            $('#state').html('');
                            $('#state').html('<option value="">select State</option>');
                            $('#city').html('');
                            $('#city').html('<option value="">select City</option>');
                        }
                    });
                }else{
                    $('#state').html('<option>Select State</option>');
                    $('#city').html('<option>Select City</option>');
                }
            });

            $('#state').change(function(){
                var state_id = $(this).val();
                var country_id = $("#country option:selected").val();

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
                            $('#city').html('');

                            if(response.code == 200){
                                $('#city').html(response.data);
                            }else{
                                $('#city').html('<option value="">select City</option>');
                            }
                        },
                        error: function(json){
                            $('#city').html('');
                            $('#city').html('<option value="">select City</option>');
                        }
                    });
                }else{
                    $('#city').html('<option>Select City</option>');
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
