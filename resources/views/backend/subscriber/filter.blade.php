@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscriber Filter
@endsection

@section('styles')
    <style>
        .A4 {
            background: white;
            /* width: 21cm;
            height: 29.7cm; */
            display: flex;
            margin: 0 auto;
            padding: 10px 25px;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            overflow-y: scroll;
            box-sizing: border-box;
            font-size: 12pt;
        }

        @media print {
            .page-break {
                display: block;
                page-break-before: always;
                size: A4 portrait;
            }
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            body * { visibility: hidden; }
            #filterData * { visibility: visible; }
            .A4 {
                box-shadow: none;
                margin: 0;
                width: auto;
                height: auto;
            }
            .noprint {
                display: none;
            }
            .enable-print {
                display: block;
            }
        }
    </style>
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
                        <h1 class="pull-right">
                            @if(auth()->user()->role_id == 1)
                                @php
                                    $filter = [
                                                'pincode' => $pincode,
                                                'city' => $city,
                                                'reporter' => $reporter,
                                                'date' => $date,
                                                'magazine' => $magazine
                                            ];
                                @endphp
                                @if(isset($data) && $data->isNotEmpty())
                                    <a href="{{ route('admin.subscriber.excel', $filter) }}" class="btn btn-primary pull-right text-white" style="margin-top: 15px !important ;margin-bottom: 5px">Export To Excel</a>
                                @else
                                    <a href="javascript:void(0);" class="btn btn-primary pull-right text-white disabled" style="margin-top: 15px !important ;margin-bottom: 5px" disabled>Export To Excel</a>
                                @endif
                            @endif
                        </h1>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ route('admin.subscriber.filter') }}" name="form" id="form" method="post">
                                    @csrf
                                    @method('POST')

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="form-group col-sm-2">
                                                    <label for="pincode">Pincode</label>
                                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ $pincode ?? NULL }}">
                                                </div>
                                                <div class="form-group col-sm-2">
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
                                                <div class="form-group col-sm-2">
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
                                                <div class="form-group col-sm-2">
                                                    <label for="date">Date</label>
                                                    <input type="text" name="date" id="date" class="form-control" placeholder="Plese enter date" autocomplete="off" value="{{ $date ?? NULL }}">
                                                </div>

                                                <div class="form-group col-sm-2">
                                                    <label for="date">Magazine</label>
                                                    <select name="magazine" class="form-control">
                                                        <option value="">Select Magazine</option>
                                                        <option value="shixan_sudha"  @if($magazine != null && $magazine == 'shixan_sudha') selected @endif>Shixan Sudha</option>
                                                        <option value="arogya_sudha" @if($magazine != null && $magazine == 'arogya_sudha') selected @endif>Arogya Sudha</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 form-group mt-4">
                                                    <label for="filter">&nbsp;</label>
                                                    <button id="filter" class="btn btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="filterData" id="filterData">
                            <div class="row mt-3 A4" id="">
                                @if(isset($data) && $data->isNotEmpty())
                                    @foreach($data as $row)
                                        <div class="col-sm-3">
                                            <ul class="media-list media-list-divider m-0">
                                                <li class="media">
                                                    <div class="media-body">
                                                        <div class="font-13 font-weight-bold">To, {{ $row->city_name ?? '' }}</div>
                                                        <div class="font-13 font-weight-bold">{{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }}</div>
                                                        <div class="font-13 font-weight-bold">{{ $row->address ?? '' }}</div>

                                                        <div class="font-13 font-weight-bold">{{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }}</div>
                                                        <div class="font-13 font-weight-bold">{{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-sm-12"><h1 class="text-center">No Data Found...!!!</h1></div>
                                @endif
                            </div>
                        </div>
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

            var max_pages = 100;
            var page_count = 0;

            function snipMe() {
                page_count++;
                if (page_count > max_pages) {
                    return;
                }
                var long = $(this)[0].scrollHeight - Math.ceil($(this).innerHeight());
                var children = $(this).children().toArray();
                var removed = [];
                while (long > 0 && children.length > 0) {
                    var child = children.pop();
                    $(child).detach();
                    removed.unshift(child);
                    long = $(this)[0].scrollHeight - Math.ceil($(this).innerHeight());
                }
                if (removed.length > 0) {
                    var a4 = $('<div class="A4"></div>');
                    a4.append(removed);
                    $(this).after(a4);
                    snipMe.call(a4[0]);
                }
            }

            $(document).ready(function() {
                $('.A4').each(function() {
                    snipMe.call(this);
                });
            });
        });
    </script>
@endsection
