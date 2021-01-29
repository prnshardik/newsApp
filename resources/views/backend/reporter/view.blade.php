@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Reporter View
@endsection

@section('styles')
    <link href="{{ asset('backend/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sweetalert2.bundle.css') }}" rel="stylesheet">
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
            <li class="breadcrumb-item">View</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporter View</div>
                    </div>
                    <div class="ibox-body">
                        <form name="form" id="form" method="post">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Plese enter firstname" value="{{ $data->firstname ?? '' }}" disabled>
                                    <span class="kt-form__help error firstname"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Plese enter lastname" value="{{ $data->lastname ?? '' }}" disabled>
                                    <span class="kt-form__help error lastname"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Plese enter email address" value="{{ $data->email ?? '' }}" disabled>
                                    <span class="kt-form__help error email"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="phone_no">Mobile Number</label>
                                    <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Plese enter country code" value="{{ $data->phone_no ?? '' }}" disabled>
                                    <span class="kt-form__help error phone_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="unique_id">Unique ID</label>
                                    <input type="text" name="unique_id" id="unique_id" class="form-control" placeholder="Plese enter unique ID" value="{{ $data->unique_id ?? '' }}" disabled>
                                    <span class="kt-form__help error unique_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address" placeholder="Please enter address" disabled>{{ $data->address ?? '' }}</textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-6"></div>
                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_start_no">Receipt Book Start</label>
                                    <input type="text" name="receipt_book_start_no" id="receipt_book_start_no" class="form-control" value="{{ $data->receipt_book_start_no ?? '' }}" placeholder="Please enter receipt book start no." disabled>
                                    <span class="kt-form__help error receipt_book_start_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="receipt_book_end_no">Receipt Book End</label>
                                    <input type="text" name="receipt_book_end_no" id="receipt_book_end_no" class="form-control" value="{{ $data->receipt_book_end_no ?? '' }}" placeholder="Please enter receipt book end no." disabled>
                                    <span class="kt-form__help error receipt_book_end_no"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="profile">Profile</label>
                                    <input type="file" class="form-control dropify" id="profile" name="profile" data-default-file="{{ $data->profile ?? '' }}" data-show-remove="false">
                                    <span class="kt-form__help error profile"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.reporter') }}" class="btn btn-secondary">Back</a>
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
            $('.dropify').dropify();

            var drEvent = $('.dropify').dropify();
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

