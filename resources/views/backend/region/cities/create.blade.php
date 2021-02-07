@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Cities Create
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
                <a href="{{ route('admin.city') }}"><span class="text-dark font-weight-bold">Cities</span></a>
            </li>
            <li class="breadcrumb-item"><span class="text-dark font-weight-bold">Create</span></li>
        </ol>
    </div> --}}
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Cities Create</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.city.insert') }}" name="form" id="form" method="post">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="" hidden>Select District</option>
                                        @if(isset($districts) && $districts->isNotEmpty())
                                            @foreach($districts as $row)
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
                                    </select>
                                    <span class="kt-form__help error taluka_id"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ @old('name') }}">
                                    <span class="kt-form__help error name"></span>
                                </div>
                               <!--  <div class="form-group col-sm-6">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ @old('pincode') }}">
                                    <span class="kt-form__help error pincode"></span>
                                </div> -->
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.city') }}" class="btn btn-secondary">Cancel</a>
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
            $("#pincode").keypress(function(e){
                var keyCode = e.keyCode || e.which;
                var $this = $(this);
                //Regex for Valid Characters i.e. Numbers.
                var regex = new RegExp("^[0-9\b]+$");

                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                // for 10 digit number only
                if ($this.val().length > 5) {
                    e.preventDefault();
                    return false;
                }

                if (regex.test(str)) {
                    return true;
                }
                e.preventDefault();
                return false;
            });

            $('#district_id').select2({
                multiple: false,
            });

            $('#taluka_id').select2({
                multiple: false,
            });

            $('#district_id').change(function(){
                var district_id = $(this).val();

                if(district_id.length > 0){
                    $.ajax({
                        url : "{{ route('admin.city.get.talukas') }}",
                        type : "post",
                        data : {
                            _token: "{{ csrf_token() }}",
                            district_id: district_id
                        },
                        success : function(response){
                            $('#taluka_id').html('');

                            if(response.code == 200){
                                $('#taluka_id').html(response.data);
                            }else{
                                $('#taluka_id').html('<option value="">select Taluka</option>');
                            }
                        },
                        error: function(json){
                            $('#taluka_id').html('');
                            $('#taluka_id').html('<option value="">select Taluka</option>');
                        }
                    });
                }else{
                    $('#taluka_id').html('');
                    $('#taluka_id').html('<option>Select Taluka</option>');
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
