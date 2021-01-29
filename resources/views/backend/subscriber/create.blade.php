@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscriber Create
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
            <li class="breadcrumb-item">Create</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Subscriber Create</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.subscriber.insert') }}" name="form" id="form" method="post">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Plese enter firstname" value="{{ @old('firstname') }}">
                                    <span class="kt-form__help error firstname"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Plese enter lastname" value="{{ @old('lastname') }}">
                                    <span class="kt-form__help error lastname"></span>
                                </div>
                                @if(auth()->user()->role_id == 1)
                                    <div class="form-group col-sm-6">
                                        <label for="receipt_no">Receipt No</label>
                                        <input type="text" name="receipt_no" id="receipt_no" class="form-control" placeholder="Plese enter receipt no" value="{{ @old('receipt_no') }}">
                                        <span class="kt-form__help error receipt_no"></span>
                                    </div>
                                @else
                                    <div class="form-group col-sm-6">
                                        <label for="receipt_no">Receipt No</label>
                                        <input type="text" name="receipt_no_1" id="receipt_no_1" class="form-control" placeholder="Plese enter receipt no" value="{{ $receipt_no }}" disabled>
                                        <input type="hidden" name="receipt_no" id="receipt_no" value="{{ $receipt_no }}" >
                                        <span class="kt-form__help error receipt_no"></span>
                                    </div>
                                @endif
                                <div class="form-group col-sm-6">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" placeholder="Plese enter description" value="{{ @old('description') }}">
                                    <span class="kt-form__help error description"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Plese enter email" value="{{ @old('email') }}">
                                    <span class="kt-form__help error email"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="phone">Phone No</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Plese enter phone no" value="{{ @old('phone') }}">
                                    <span class="kt-form__help error phone"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Plese enter address" value="{{ @old('address') }}">
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ @old('pincode') }}">
                                    <span class="kt-form__help error pincode"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="magazine">Magazine</label>
                                    <select name="magazine" id="magazine" class="form-control">
                                        <option value="" hidden>Select Magazine</option>
                                        <option value="shixan_sudha">Shixan Sudha</option>
                                        <option value="arogya_sudha">Arogya Sudha</option>
                                    </select>
                                    <span class="kt-form__help error magazine"></span>
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

            $('#magazine').select2({
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
