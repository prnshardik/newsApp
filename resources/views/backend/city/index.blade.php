@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
    Country
@endsection

@section('styles')
@endsection

@section('content')
<div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    
                    <div class="ibox-head">
                        <h1 class="ibox-title">Country</h1>
                        <h1 class="pull-right">
                           <a class="btn btn-primary pull-right" style="margin-top: 8px;margin-bottom: 5px" href="{{ route('admin.country.create') }}">Add New</a>
                        </h1>
                    </div>            
                       
                    <div class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <table class="table table-bordered data-table" id="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Country Code</th>
                                    <th width="100px">Action</th>
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
        var list_table_one;
            $(document).ready(function() {
                if($('#data-table').length > 0){
                    list_table_one = $('#data-table').DataTable({
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

                        lengthChange: false,

                        "ajax":{
                            "url": "{{ route('admin.country') }}",
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
                                data: 'country_code',
                                name: 'country_code'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                            },
                        ]
                    });
                }
            });

            function delete_func(a_object){
                var id = $(a_object).data("id");
                if (confirm('Are You Sure You Want To Delete?')) {
                    $.ajax({
                        "url": "{!! route('admin.country.delete') !!}",
                        "dataType": "json",
                        "type": "POST",
                        "data":{
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response){
                            if (response.code == 200){
                                list_table_one.ajax.reload();
                                toastr.success('Record deleted successfully.', 'Success');
                            }else{
                                toastr.error('Failed to delete record.', 'Error');
                            }
                        }
                    });
                }
            }
    </script>
@endsection
