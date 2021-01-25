@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscription Edit
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
                <a href="{{ route('admin.subscription') }}">Subscriptions</i></a>
            </li>
            <li class="breadcrumb-item">Edit</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Subscription Edit</div>
                    </div>
                    <div class="ibox-body">
                        <form action="{{ route('admin.subscription.update') }}" name="form" id="form" method="post">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="id" value="{{ $data->id }}">

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="start_date">Start Date</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Plese select startdate" value="{{ @old('start_date') }}">
                                    <span class="kt-form__help error start_date"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="end_date">End Date</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control" placeholder="Plese select end date" value="{{ @old('end_date') }}">
                                    <span class="kt-form__help error end_date"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.subscription') }}" class="btn btn-secondary">Cancel</a>
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
        $(document).ready(function () {
            $('#start_date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy/mm/dd"
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('#end_date').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('#end_date').datepicker('setStartDate', null);
            });

            $('#end_date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy/mm/dd"
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('#start_date').datepicker('setEndDate', startDate);
            }).on('clearDate', function (selected) {
                $('#start_date').datepicker('setStartDate', null);
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
