@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscriber Edit
@endsection

@section('styles')
@endsection

@section('content')
    {{-- <div class="page-heading mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><span class="text-dark font-weight-bold">Dashboard</span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.subscriber') }}"><span class="text-dark font-weight-bold">Subscribers</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Edit</span></li>
        </ol>
    </div> --}}
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-body">
                        <form action="{{ route('admin.subscriber.update') }}" name="form" id="form" method="post">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="receipt_no">Receipt No</label>
                                    <input type="text" name="receipt_no_1" id="receipt_no_1" class="form-control" placeholder="Plese enter receipt_no" value="{{ $data->receipt_no ?? '' }}" disabled>
                                    <input type="hidden" name="receipt_no" id="receipt_no" value="{{ $data->receipt_no ?? '' }}">
                                    <span class="kt-form__help error receipt_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="magazine">Magazine</label>
                                    <div class="m-b-10">
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="shixan_sudha" @if(isset($data) && $data->magazine == 'shixan_sudha') checked @endif>
                                            <span class="input-span"></span>Shixan Sudha
                                        </label>
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="arogya_sudha" @if(isset($data) && $data->magazine == 'arogya_sudha') checked @endif>
                                            <span class="input-span"></span>Arogya Sudha
                                        </label>
                                    </div>
                                    <span class="kt-form__help error magazine"></span>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Subscriber Edit</div>
                    </div>
                    <div class="ibox-body">
                        {{-- <form action="{{ route('admin.subscriber.update') }}" name="form" id="form" method="post">
                            @csrf
                            @method('PATCH') --}}

                            <input type="hidden" name="id" value="{{ $data->id }}">

                            <div class="row">
                                {{-- <div class="form-group col-sm-6">
                                    <label for="receipt_no">Receipt No</label>
                                    <input type="text" name="receipt_no_1" id="receipt_no_1" class="form-control" placeholder="Plese enter receipt_no" value="{{ $data->receipt_no ?? '' }}" disabled>
                                    <input type="hidden" name="receipt_no" id="receipt_no" value="{{ $data->receipt_no ?? '' }}">
                                    <span class="kt-form__help error receipt_no"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="magazine">Magazine</label>
                                    <div class="m-b-10">
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="shixan_sudha" @if(isset($data) && $data->magazine == 'shixan_sudha') checked @endif>
                                            <span class="input-span"></span>Shixan Sudha
                                        </label>
                                        <label class="ui-radio ui-radio-inline ui-radio-success">
                                            <input type="radio" name="magazine" value="arogya_sudha" @if(isset($data) && $data->magazine == 'arogya_sudha') checked @endif>
                                            <span class="input-span"></span>Arogya Sudha
                                        </label>
                                    </div>
                                    <span class="kt-form__help error magazine"></span>
                                </div> --}}
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
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Plese enter email" value="{{ $data->email ?? '' }}">
                                    <span class="kt-form__help error email"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="phone">Phone No</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Plese enter phone no" value="{{ $data->phone ?? '' }}">
                                    <span class="kt-form__help error phone"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Plese enter address" cols="30" rows="3">{{ $data->address ?? '' }}</textarea>
                                    <span class="kt-form__help error address"></span>
                                </div>
                                <div class="form-group col-sm-3">
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
                                <div class="form-group col-sm-3">
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
                                <div class="form-group col-sm-3">
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
                                <div class="form-group col-sm-3">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ $data->pincode ?? '' }}">
                                    <span class="kt-form__help error pincode"></span>
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
        });

        // $('#city_id').change(function(){
        //     var pincode = $("#city_id option:selected").data('id');
        //     if(pincode != ''){
        //         $('#pincode').val(pincode);
        //     }
        // });
    </script>

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
