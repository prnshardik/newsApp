@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Subscribers
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
            {{-- <li class="breadcrumb-item">Index</li> --}}
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <h1 class="ibox-title">Subscribers</h1>
                        <h1 class="pull-right">
                            @canany(['subscriber-create'])
                                <a class="btn btn-primary pull-right ml-2" style="margin-top: 8px;margin-bottom: 5px" href="{{ route('admin.subscriber.create') }}">Add New</a>
                            @endcanany

                            @if(auth()->user()->role_id == 1)
                                <a class="btn btn-primary pull-right ibox-collapse text-white" style="margin-top: 8px;margin-bottom: 5px">Filters</a>
                            @endif
                        </h1>
                    </div>

                    <div class="ibox-body" style="display: none;">
                        <form action="{{ route('admin.subscriber.filter') }}" name="form" id="form" method="post">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="form-group col-sm-2">
                                            <label for="pincode">Pincode</label>
                                            <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Plese enter pincode" value="{{ $pincode ?? NULL }}">
                                            <span class="kt-form__help error pincode"></span>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label for="reporter">Reporter</label>
                                            <select name="reporter" id="reporter" class="form-control">
                                                <option value="">Select Reporter</option>
                                                @if(isset($reporters) && $reporters->isNotEmpty())
                                                    @foreach($reporters as $row)
                                                        <option value="{{ $row->id }}">{{ $row->firstname }} {{ $row->lastname }}</option>
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
                                                <option value="shixan_sudha">Shixan Sudha</option>
                                                <option value="arogya_sudha">Arogya Sudha</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-2 mt-4">
                                            <label for="filter">&nbsp;</label>
                                            <button id="filter" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <table class="table table-bordered data-table" id="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Receipt No</th>
                                    <th>Phone</th>
                                    <th>Pincode</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="text-center"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
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
        });

        var datatable;


        $(document).ready(function() {
            if($('#data-table').length > 0){
                datatable = $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,

                    // "pageLength": 10,
                    // "iDisplayLength": 10,
                    "responsive": true,
                    "aaSorting": [],
                    // "order": [], //Initial no order.
                    //     "aLengthMenu": [
                    //     [5, 10, 25, 50, 100, -1],
                    //     [5, 10, 25, 50, 100, "All"]
                    // ],

                    // "scrollX": true,
                    // "scrollY": '',
                    // "scrollCollapse": false,
                    // scrollCollapse: true,

                    // lengthChange: false,

                    "ajax":{
                        "url": "{{ route('admin.subscriber') }}",
                        "type": "POST",
                        "dataType": "json",
                        "data":{
                            _token: "{{csrf_token()}}"
                        }
                    },
                    "columnDefs": [{
                            //"targets": [0, 5], //first column / numbering column
                            "orderable": true, //set not orderable
                        },
                    ],
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'receipt_no',
                            name: 'receipt_no'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'pincode',
                            name: 'pincode'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                        },
                    ]
                });
            }

            // $('#reporter').select2({
            //     multiple: false,
            // });

            // $('#city').select2({
            //     multiple: false,
            // });

            $('#date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy/mm/dd"
            });
        });

        function change_status(object){
            var id = $(object).data("id");
            var status = $(object).data("status");
            var old_status = $(object).data("old_status");

            if(old_status == 'block' && status == 'active'){
                var msg = "Are you Sure You Want To Active This Record?";
            }else if(old_status == 'block' && status == 'block'){
                var msg = "Are you Sure You Want To Block This Record?";
            }else if(old_status == 'block' && status == 'deleted'){
                var msg = "Are you Sure You Want To Delete This Record?";
            }else if(old_status == 'inactive' && status == 'active'){
                var msg = "Are you Sure You Want To Reactive This Record?";
            }else{
                var msg = "Are you Sure?";
            }

            if (confirm(msg)) {
                $.ajax({
                    "url": "{!! route('admin.subscriber.change.status') !!}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                        id: id,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response){
                        if (response.code == 200){
                            datatable.ajax.reload();
                            toastr.success('Record status changed successfully.', 'Success');
                        }else{
                            toastr.error('Failed to delete record.', 'Error');
                        }
                    }
                });
            }
        }
    </script>
@endsection
