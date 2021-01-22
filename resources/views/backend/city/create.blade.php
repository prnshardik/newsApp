@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Create Country
@endsection

@section('styles')
@endsection

@section('content')
   <div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Create Country</div>
                </div>
                <div class="ibox-body">
                    <form action="{{ route('admin.country.insert') }}" name="form" id="form" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Plese Enter Name" value="{{ @old('name') }}">
                                <span class="kt-form__help error name"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="country_code">Country Code</label>
                                <input type="text" class="form-control" id="country_code" name="country_code" placeholder="Plese Enter Country Code" value="{{ @old('country_code') }}">
                                <span class="kt-form__help error country_code"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.country') }}">
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('#country_code').keypress(function(e){
                if (/\D/g.test(this.value)){
                    this.value = this.value.replace(/\D/g, '');
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
