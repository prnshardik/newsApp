@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscriber Filter
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
            <li class="breadcrumb-item">Subscriber Filter</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Subscriber Filter</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('admin.subscriber.filter') }}" name="form" id="form" method="post">
                                    @csrf
                                    @method('POST')

                                    <div class="row">
                                        <div class="col-sm-11">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label for="pincode">Pincode</label>
                                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ $pincode ?? NULL }}">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="city">City</label>
                                                    <select name="city" id="city" class="form-control">
                                                        <option value="">Select City</option>
                                                        @if(isset($cities) && $cities->isNotEmpty())
                                                            @foreach($cities as $row)
                                                                <option value="{{ $row->id }}" @if($city != null && $city == $row->id) selected @endif>{{ $row->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="reporter">Reporter</label>
                                                    <select name="reporter" id="reporter" class="form-control">
                                                        <option value="">Select Reporter</option>
                                                        @if(isset($reporters) && $reporters->isNotEmpty())
                                                            @foreach($reporters as $row)
                                                                <option value="{{ $row->id }}" @if($reporter != null && $reporter == $row->id) selected @endif>{{ $row->firstname }} {{ $row->lastname }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="date">Date</label>
                                                    <input type="text" name="date" id="date" class="form-control" placeholder="Plese enter date" autocomplete="off" value="{{ $date ?? NULL }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label for="filter">&nbsp;</label>
                                                <button id="filter" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-3" id="filterData">
                            @if(isset($data) && $data->isNotEmpty())
                                @foreach($data as $row)
                                    <div class="col-sm-3">
                                        <ul class="media-list media-list-divider m-0">
                                            <li class="media">
                                                <div class="media-body">
                                                    <div class="font-13 font-weight-bold">To.</div>
                                                    <div class="font-13 font-weight-bold">{{ $row->city_name ?? '' }}</div>
                                                    <div class="font-13 font-weight-bold">{{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }}</div>
                                                    <div class="font-13 font-weight-bold">{{ $row->address ?? '' }}</div>
                                                    <div class="font-13 font-weight-bold">{{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }}</div>
                                                    <div class="font-13 font-weight-bold">{{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }}</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- <div class="row mt-2">
                            <div class="col-sm-12 text-right">
                                <button class="btn btn-primary mr-5" id="pdf" onClick="printdiv('filterData');">PDF</button>
                            </div>
                        </div> --}}
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

            $('#date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy/mm/dd"
            });
        });
    </script>
@endsection
