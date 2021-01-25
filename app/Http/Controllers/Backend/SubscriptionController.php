<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Subscription;
    use App\Http\Requests\SubscriptionRequest;
    use DataTables, DB;
    use Spatie\Permission\Models\Role;

    class SubscriptionController extends Controller{

        public function __construct(){
            $this->middleware('permission:subscription-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:subscription-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:subscription-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:subscription-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                // $collections = DB::table('subscribers as s')
                //                     ->select('s.id', 's.receipt_no', 's.phone', 's.pincode', 's.status',
                //                                 DB::Raw("CONCAT(".'u.firstname'.", ' ', ".'u.lastname'.") as name"),
                //                                 'ct.name as city_name', 'st.name as state_name'
                //                             )
                //                     ->join('users as u', 'u.id', 's.user_id')
                //                     ->join('state as st', 'st.id', 's.state')
                //                     ->join('city as ct', 'ct.id', 's.city');

                // if(auth()->user()->role_id != 1)
                //     $collections->where(['s.created_by' => auth()->user()->id]);

                // $data = $collections->orderBy('s.id', 'desc')
                //                     ->get();

                // return Datatables::of($data)
                //         ->addIndexColumn()
                //         ->addColumn('action', function($data){
                //             $return = '<div class="btn-group">';

                //             if(auth()->user()->can('subscriber-view')){
                //                 $return .=  '<a href="'.route('admin.subscriber.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                //                                 <i class="fa fa-eye"></i>
                //                             </a> &nbsp;';
                //             }

                //             if(auth()->user()->can('subscriber-edit')){
                //                 $return .= '<a href="'.route('admin.subscriber.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                //                                 <i class="fa fa-edit"></i>
                //                             </a> &nbsp;';
                //             }

                //             if(auth()->user()->can('subscriber-delete')){
                //                 $return .= '<a href="javascript:;" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                //                                 <i class="fa fa-bars"></i>
                //                             </a> &nbsp;
                //                             <ul class="dropdown-menu">
                //                                 <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="active" data-id="'.base64_encode($data->id).'">Active</a></li>
                //                                 <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="inactive" data-id="'.base64_encode($data->id).'">Inactive</a></li>
                //                                 <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="deleted" data-id="'.base64_encode($data->id).'">Delete</a></li>
                //                             </ul>';
                //             }

                //             $return .= '</div>';

                //             return $return;
                //         })

                //         ->editColumn('status', function($data) {
                //             if($data->status == 'active'){
                //                 return '<span class="badge badge-pill badge-success">Active</span>';
                //             }else if($data->status == 'inactive'){
                //                 return '<span class="badge badge-pill badge-warning">Inactive</span>';
                //             }else if($data->status == 'deleted'){
                //                 return '<span class="badge badge-pill badge-danger">Delete</span>';
                //             }else{
                //                 return '-';
                //             }
                //         })

                //         ->rawColumns(['action', 'status'])
                //         ->make(true);
            }

            return view('backend.subscription.index');
        }

        public function create(Request $request){
            return view('backend.subscription.create');
        }

        public function insert(SubscriptionRequest $request){
            if($request->ajax()){ return true; }

            $role_id = 3;
            $crud = [
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $subscription = Subscription::create($crud);

            if($subscription)
                return redirect()->route('admin.subscription')->with('success', 'Subscription inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
            $data = Subscription::get();
            return view('backend.subscription.edit')->with(['data' => $data]);
        }

        public function update(SubscriptionRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;

            $crud = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $update = Subscription::where(['id' => $id])->update($crud);

            if($update)
                return redirect()->route('admin.subscription')->with('success', 'Subscription updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();

        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
            $data = Subscription::get();
            return view('backend.subscription.view')->with(['data' => $data]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $subscription = Subscription::where(['id' => $id])->first();

                if(!empty($subscription)){
                    $update = Subscription::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                    if($update)
                        return response()->json(['code' => 200]);
                    else
                        return response()->json(['code' => 201]);
                }else{
                    return response()->json(['code' => 201]);
                }
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
