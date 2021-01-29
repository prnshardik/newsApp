@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Change Password
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
                <a href="{{ route('admin.profile') }}"><span class="text-dark font-weight-bold">Profile</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Change Password</span></li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Change Password</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.profile.reset.password') }}" name="form" id="form" method="post">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Plese enter current password">
                                    <span class="kt-form__help error current_password"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Plese enter new password">
                                    <span class="kt-form__help error new_password"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Plese enter new Confirm Password">
                                    <span class="kt-form__help error confirm_password"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.profile') }}" class="btn btn-secondary">Cancel</a>
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
        $(function() {
            $("#form").validate({
                errorElement: "div", // contain the error msg in a span tag
                errorClass: 'invalid-feedback',
                errorPlacement: function (error, element) { // render error placement for each input type
                    error.insertAfter(element);
                },
                ignore: "",
                rules: {
                    current_password: {
                        required: true,
                        minlength : 7
                    },
                    new_password: {
                        required: true,
                        minlength : 7,
                        notEqual: '#current_password'
                    },
                    confirm_password: {
                        required: true,
                        minlength : 7,
                        equalTo : "#new_password"
                    }
                },
                messages: {
                    current_password: {
                        required: 'Please enter current password.',
                        minlength: 'Password length should be 7 character'
                    },
                    new_password: {
                        required: 'Please enter new password.',
                        minlength: 'Password length should be 7 character'
                    },
                    confirm_password: {
                        required: 'Please enter confirm password.',
                        minlength: 'Password length should be 7 character'
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit
                    //successHandler1.hide();
                    //errorHandler1.show();
                },
                highlight: function (element) {
                    $(element).closest('.help-block').removeClass('valid');
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error');
                },
                success: function (label, element) {
                    label.addClass('help-block valid');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                },
                // submitHandler: function (form) {
                    // successHandler1.show();
                    // errorHandler1.hide();
                // }
            });
            jQuery.validator.addMethod("notEqual", function(value, element, param) {
                return this.optional(element) || value != $(param).val();
            }, "new password should not same as old.");
        });
    </script>
@endsection

