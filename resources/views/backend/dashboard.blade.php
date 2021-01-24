@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Dashboard
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-content fade-in-up">
        <div class="row">
            @if(auth()->user()->role_id == 1)
                <div class="col-lg-3 col-md-6">
                    <div class="ibox bg-success color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">{{ $total_reporters->count ?? 0 }}</h2>
                            <div class="m-b-5">Total Agents</div><i class="ti-user widget-stat-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="ibox bg-info color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">{{ $active_reporters->count ?? 0 }}</h2>
                            <div class="m-b-5">Active Agents</div><i class="ti-user widget-stat-icon"></i>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-3 col-md-6">
                <div class="ibox bg-warning color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{ $total_subscribers->count ?? 0 }}</h2>
                        <div class="m-b-5">Total Subscribers</div><i class="ti-user widget-stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{ $active_subscribers->count ?? 0 }}</h2>
                        <div class="m-b-5">Active Subscribers</div><i class="ti-user widget-stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role_id == 1)
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox">
                        <div class="ibox-head">
                            <div class="ibox-title">Recent Agents</div>
                            <div class="ibox-tools">
                                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                        </div>
                        <div class="ibox-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Unique Id</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Receipt Book No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($agents) && $agents->isNotEmpty())
                                        @php $i = 1;  @endphp
                                        @foreach($agents as $row)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $row->unique_id ?? '' }}</td>
                                                <td>{{ $row->name ?? '' }}</td>
                                                <td>{{ $row->phone_no ?? '' }}</td>
                                                <td>{{ $row->state_name ?? '' }}</td>
                                                <td>{{ $row->city_name ?? '' }}</td>
                                                <td>{{ $row->receipt_book_no ?? '' }}</td>
                                                @php $i++; @endphp
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Recent Subscribers</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Receipt No</th>
                                    <th>Phone</th>
                                    <th>Pincode</th>
                                    <th>State</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($subscribers) && $subscribers->isNotEmpty())
                                    @php $i = 1;  @endphp
                                    @foreach($subscribers as $row)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $row->name ?? '' }}</td>
                                            <td>{{ $row->receipt_no ?? '' }}</td>
                                            <td>{{ $row->phone ?? '' }}</td>
                                            <td>{{ $row->pincode ?? '' }}</td>
                                            <td>{{ $row->state_name ?? '' }}</td>
                                            <td>{{ $row->city_name ?? '' }}</td>
                                            @php $i++; @endphp
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('backend/js/scripts/dashboard_1_demo.js') }}" type="text/javascript"></script>
@endsection
