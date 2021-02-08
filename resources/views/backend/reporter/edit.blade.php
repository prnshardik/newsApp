@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Reporter Edit
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
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Edit</span></li>
        </ol>
    </div> --}}
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporter Edit</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.reporter.update') }}" name="form" id="form" method="post" enctype="multipart/form-data">
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
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Plese enter email address" value="{{ $data->email ?? '' }}">
                                    <span class="kt-form__help error email"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="phone_no">Mobile Number</label>
                                    <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Plese enter country code" value="{{ $data->phone_no ?? '' }}">
                                    <span class="kt-form__help error phone_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="unique_id">Unique ID</label>
                                    <input type="text" name="unique_id" id="unique_id" class="form-control" placeholder="Plese enter unique ID" value="{{ $data->unique_id ?? '' }}">
                                    <span class="kt-form__help error unique_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address" placeholder="Please enter address">{{ $data->address ?? '' }}</textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-6"></div>
                                <div class="form-group col-sm-6">
                                    <label for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="" hidden>Select District</option>
                                        @if(isset($districts) && $districts->isNotEmpty())
                                            @foreach($districts AS $row)
                                                <option value="{{ $row->id }}"  @if(isset($data) && $data->district_id == $row->id) selected @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error district_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="taluka_id">Taluka</label>
                                    <select name="taluka_id" id="taluka_id" class="form-control">
                                        <option value="" hidden>Select Taluka</option>
                                        @if(isset($talukas) && !empty($talukas))
                                            @foreach($talukas as $row)
                                                <option value="{{ $row['id'] }}" @if(isset($data) && $data->taluka_id == $row['id']) selected @endif>{{ $row['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error taluka_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="" hidden>Select City</option>
                                        @if(isset($cities) && !empty($cities))
                                            @foreach($cities as $row)
                                                <option value="{{ $row['id'] }}" @if(isset($data) && $data->city_id == $row['id']) selected @endif>{{ $row['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="kt-form__help error city_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_start_no">Receipt Book Start</label>
                                    <input type="text" name="receipt_book_start_no" id="receipt_book_start_no" class="form-control" value="{{ $data->receipt_book_start_no ?? '' }}" placeholder="Please enter receipt book start no.">
                                    <span class="kt-form__help error receipt_book_start_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_end_no">Receipt Book End</label>
                                    <input type="text" name="receipt_book_end_no" id="receipt_book_end_no" class="form-control" value="{{ $data->receipt_book_end_no ?? '' }}" placeholder="Please enter receipt book end no.">
                                    <span class="kt-form__help error receipt_book_end_no"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="profile">Profile</label>
                                    <input type="file" class="form-control dropify" id="profile" name="profile" data-default-file="{{ $data->profile ?? '' }}" data-allowed-file-extensions="jpg png jpeg" data-max-file-size-preview="2M">
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

