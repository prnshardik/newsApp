@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Reporter Create
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
                <a href="{{ route('admin.reporter') }}">Reporters</i></a>
            </li>
            <li class="breadcrumb-item">Create</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporter Create</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.reporter.insert') }}" name="form" id="form" method="post">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Plese enter firstname" value="{{ @old('firstname') }}">
                                    <span class="kt-form__help error firstname"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Plese enter lastname" value="{{ @old('lastname') }}">
                                    <span class="kt-form__help error lastname"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Plese enter email address" value="{{ @old('email') }}">
                                    <span class="kt-form__help error email"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="phone_no">Mobile Number</label>
                                    <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Plese enter country code" value="{{ @old('phone_no') }}">
                                    <span class="kt-form__help error phone_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="unique_id">Unique ID</label>
                                    <input type="text" name="unique_id" id="unique_id" class="form-control" placeholder="Plese enter Unique ID" value="{{ @old('unique_id') }}">
                                    <span class="kt-form__help error unique_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address" placeholder="Please enter address">{{ @old('address') }}</textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="country_id">Country</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="" hidden>Select Country</option>
                                        @if(isset($countries) && $countries->isNotEmpty())
                                            @foreach($countries AS $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error country_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="state_id">State</label>
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="" hidden>Select State</option>
                                    </select>
                                    <span class="kt-form__help error state_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="" hidden>Select City</option>
                                    </select>
                                    <span class="kt-form__help error city_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Please Enter Password">
                                    <span class="kt-form__help error password"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_start_no">Receipt Book Start</label>
                                    <input type="text" name="receipt_book_start_no" id="receipt_book_start_no" class="form-control" value="{{ @old('receipt_book_start_no')}}" placeholder="Please enter receipt book start no.">
                                    <span class="kt-form__help error receipt_book_start_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_end_no">Receipt Book End</label>
                                    <input type="text" name="receipt_book_end_no" id="receipt_book_end_no" class="form-control" value="{{ @old('receipt_book_end_no')}}" placeholder="Please enter receipt book end no.">
                                    <span class="kt-form__help error receipt_book_end_no"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.reporter') }}" class="btn btn-secondary">Cancel</a>
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
