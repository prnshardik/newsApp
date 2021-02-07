@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Reporter Create
@endsection

@section('styles')
    <link href="{{ asset('backend/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sweetalert2.bundle.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- <div class="page-heading mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><span class="text-dark font-weight-bold">Dashboard</span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.reporter') }}"><span class="text-dark font-weight-bold">Reporters</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Create</span></li>
        </ol>
    </div> --}}
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporter Create</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.reporter.insert') }}" name="form" id="form" method="post" enctype="multipart/form-data">
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
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Please Enter Password">
                                    <span class="kt-form__help error password"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address" placeholder="Please enter address">{{ @old('address') }}</textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="" hidden>Select District</option>
                                        @if(isset($districts) && $districts->isNotEmpty())
                                            @foreach($districts AS $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error district_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="taluka_id">Taluka</label>
                                    <select name="taluka_id" id="taluka_id" class="form-control">
                                        <option value="" hidden>Select Taluka</option>
                                        @if(isset($talukas) && $talukas->isNotEmpty())
                                            @foreach($talukas AS $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error taluka_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="" hidden>Select City</option>
                                        @if(isset($cities) && $cities->isNotEmpty())
                                            @foreach($cities AS $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error city_id"></span>
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
                                <div class="form-group col-sm-12">
                                    <label for="profile">Profile</label>
                                    <input type="file" class="form-control dropify" id="profile" name="profile" data-allowed-file-extensions="jpg png jpeg" data-max-file-size-preview="2M">
                                    <span class="kt-form__help error profile"></span>
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
    <script src="{{ asset('backend/js/dropify.min.js') }}"></script>
    <script src="{{ asset('backend/js/promise.min.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert2.bundle.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#district_id').select2({
                multiple: false,
            });

            $('#taluka_id').select2({
                multiple: false,
            });

            $('#city_id').select2({
                multiple: false,
            });

            // $('#district_id').change(function(){
            //     var district_id = $(this).val();

            //     if(district_id.length > 0){
            //         $.ajax({
            //             url : "{{ route('admin.city.get.talukas') }}",
            //             type : "post",
            //             data : {
            //                 _token: "{{ csrf_token() }}",
            //                 district_id: district_id
            //             },
            //             success : function(response){
            //                 $('#taluka_id').html('');
            //                 $('#city_id').html('');

            //                 if(response.code == 200){
            //                     $('#taluka_id').html(response.data);
            //                     $('#city_id').html('<option value="">select City</option>');
            //                 }else{
            //                     $('#taluka_id').html('<option value="">select Taluka</option>');
            //                     $('#city_id').html('<option value="">select City</option>');
            //                 }
            //             },
            //             error: function(json){
            //                 $('#taluka_id').html('');
            //                 $('#city_id').html('');
            //                 $('#taluka_id').html('<option value="">select Taluka</option>');
            //                 $('#city_id').html('<option value="">select City</option>');
            //             }
            //         });
            //     }else{
            //         $('#taluka_id').html('');
            //         $('#city_id').html('');
            //         $('#taluka_id').html('<option value="">select Taluka</option>');
            //         $('#city_id').html('<option value="">select City</option>');
            //     }
            // });

            // $('#taluka_id').change(function(){
            //     var taluka_id = $(this).val();

            //     if(taluka_id.length > 0){
            //         $.ajax({
            //             url : "{{ route('admin.city.get.cities') }}",
            //             type : "post",
            //             data : {
            //                 _token: "{{ csrf_token() }}",
            //                 taluka_id: taluka_id
            //             },
            //             success : function(response){
            //                 $('#city_id').html('');

            //                 if(response.code == 200){
            //                     $('#city_id').html(response.data);
            //                 }else{
            //                     $('#city_id').html('<option value="">select City</option>');
            //                 }
            //             },
            //             error: function(json){
            //                 $('#city_id').html('');
            //                 $('#city_id').html('<option value="">select City</option>');
            //             }
            //         });
            //     }else{
            //         $('#city_id').html('<option>Select City</option>');
            //     }
            // });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop profile image here or click',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happended.'
                }
            });

            var drEvent = $('.dropify').dropify();

            var dropifyElements = {};
            $('.dropify').each(function () {
                dropifyElements[this.id] = false;
            });

            drEvent.on('dropify.beforeClear', function(event, element){
                id = event.target.id;
                if(!dropifyElements[id]){
                    var url = "{!! route('admin.reporter.profile.remove') !!}";
                    <?php if(isset($data) && isset($data->id)){ ?>
                        var id_encoded = "{{ base64_encode($data->id) }}";

                        Swal.fire({
                            title: 'Are you sure want delete this image?',
                            text: "",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then(function (result){
                            if (result.value){
                                $.ajax({
                                    url: url,
                                    type: "POST",
                                    data:{
                                        id: id_encoded,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    dataType: "JSON",
                                    success: function (data){
                                        if(data.code == 200){
                                            Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                                            dropifyElements[id] = true;
                                            element.clearElement();
                                        }else{
                                            Swal.fire('', 'Failed to delete', 'error');
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown){
                                        Swal.fire('', 'Failed to delete', 'error');
                                    }
                                });
                            }
                        });

                        return false;
                    <?php } else { ?>
                        Swal.fire({
                            title: 'Are you sure want delete this image?',
                            text: "",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then(function (result){
                            if (result.value){
                                Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                                dropifyElements[id] = true;
                                element.clearElement();
                            }else{
                                Swal.fire('Cancelled', 'Discard Last Operation.', 'error');
                            }
                        });
                        return false;
                    <?php } ?>
                } else {
                    dropifyElements[id] = false;
                    return true;
                }
            });
        });
    </script>

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
