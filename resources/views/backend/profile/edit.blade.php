@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Profile Edit
@endsection

@section('styles')
  <link href="{{ asset('backend/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sweetalert2.bundle.css') }}" rel="stylesheet">
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
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Edit</span></li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Profile Edit</div>
                    </div> 
                    <div class="ibox-body">
                        <form action="{{ route('admin.profile.update') }}" name="form" id="form" enctype="multipart/form-data" method="post">
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
                                <div class="form-group col-sm-12">
                                    <label for="profile">Profile</label>
                                    <input type="file" class="form-control dropify" id="profile" name="profile" data-default-file="{{ $data->profile ?? '' }}"  data-allowed-file-extensions="jpg png jpeg" data-max-file-size-preview="2M" data-show-remove="false">
                                    <span class="kt-form__help error profile"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.profile') }}" class="btn btn-secondary">Back</a>
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

