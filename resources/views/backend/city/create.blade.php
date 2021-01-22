@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Create City
@endsection

@section('styles')
@endsection

@section('content')
   <div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Create City</div>
                </div>
                <div class="ibox-body">
                    <form action="{{ route('admin.city.insert') }}" name="form" id="form" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="country_code">Country Name</label>
                                <select class="form-control" id="country_id" name="country_id">
                                    <option value="" hidden>Selct Country</option>
                                    @foreach($country AS $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="kt-form__help error country_id"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="state_id">State Name</label>
                                <select class="form-control" id="state_id" name="state_id">
                                    <option value="" hidden>Selct State</option>
                                </select>
                                <span class="kt-form__help error state_id"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Plese Enter Name" value="{{ @old('name') }}">
                                <span class="kt-form__help error name"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.state') }}">
                                <button type="button" class="btn btn-secondary">Cancel</button>
                            </a>
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
        $('#country_id').select2({
            multiple: false,
        });
        $('#state_id').select2({
            multiple: false,
        });
    </script>

    <script>
        $('#country_id').change(function(){
            var country_id = $(this).val();

            if(country_id.length > 0){
                $.ajax({
                    url : "{{ route('admin.city.get_state') }}",
                    type : "post",
                    data : {
                        _token: "{{ csrf_token() }}",
                        country_id: country_id,
                    },
                    success : function(response){
                        $('#state_id').html('');

                        if(response.code == 200){
                            $('#state_id').html(response.data);
                        }else{
                            $('#state_id').html('<option value="">select state</option>');
                        }
                    },
                    error: function(json){
                        $('#state_id').html('');
                        $('#state_id').html('<option value="">select state</option>');
                    }
                });
            }else{
                $('#state_id').html('<option>Select State</option>');
            }
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
