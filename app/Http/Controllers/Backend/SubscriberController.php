<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Subscriber;
    use App\Models\User;
    use App\Models\Country;
    use App\Http\Requests\SubscriberRequest;
    use DataTables, DB;
    use Spatie\Permission\Models\Role;

    class SubscriberController extends Controller{

        public function __construct(){
            $this->middleware('permission:subscriber-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:subscriber-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:subscriber-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:subscriber-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('subscribers as s')
                            ->select('s.id', 's.receipt_no', 's.phone', 's.pincode', 's.status',
                                        DB::Raw("CONCAT(".'u.firstname'.", ' ', ".'u.lastname'.") as name"),
                                        'ct.name as city_name', 'st.name as state_name'
                                    )
                            ->join('users as u', 'u.id', 's.user_id')
                            ->join('state as st', 'st.id', 's.state')
                            ->join('city as ct', 'ct.id', 's.city')
                            ->orderBy('id', 'desc')
                            ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('subscriber-view')){
                                $return .=  '<a href="'.route('admin.subscriber.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('subscriber-edit')){
                                $return .= '<a href="'.route('admin.subscriber.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('subscriber-delete')){
                                $return .= '<a href="javascript:;" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-bars"></i>
                                            </a> &nbsp;
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="active" data-id="'.base64_encode($data->id).'">Active</a></li>
                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="inactive" data-id="'.base64_encode($data->id).'">Inactive</a></li>
                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="deleted" data-id="'.base64_encode($data->id).'">Delete</a></li>
                                            </ul>';
                            }

                            $return .= '</div>';

                            return $return;
                        })

                        ->editColumn('status', function($data) {
                            if($data->status == 'active'){
                                return '<span class="badge badge-pill badge-success">Active</span>';
                            }else if($data->status == 'inactive'){
                                return '<span class="badge badge-pill badge-warning">Inactive</span>';
                            }else if($data->status == 'deleted'){
                                return '<span class="badge badge-pill badge-danger">Delete</span>';
                            }else{
                                return '-';
                            }
                        })

                        ->rawColumns(['action', 'status'])
                        ->make(true);
            }

            return view('backend.subscriber.index');
        }

        public function create(Request $request){
            $countries = Country::get();
            return view('backend.subscriber.create', ['countries' => $countries]);
        }

        public function insert(SubscriberRequest $request){
            if($request->ajax()){ return true; }

            $role_id = 3;
            $crud = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname),
                'email' => $request->email ?? NULL,
                'role_id' => $role_id,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            DB::beginTransaction();
            try {
                $user = User::create($crud);

                if($user){
                    $subscriber_crud = [
                        'user_id' => $user->id,
                        'receipt_no' => $request->receipt_no,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'pincode' => $request->pincode,
                        'country' => $request->country,
                        'state' => $request->state,
                        'city' => $request->city,
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => auth()->user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->id
                    ];

                    $subscriber_last_id = Subscriber::insertGetId($subscriber_crud);

                    if($subscriber_last_id > 0){
                        $user->assignRole($role_id);

                        DB::commit();
                        return redirect()->route('admin.subscriber')->with('success', 'Subscriber inserted successfully.');
                    }else{
                        DB::rollback();
                        return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                    }
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
            $countries = Country::get();
            $states = [];
            $cities = [];

            $data = DB::table('subscribers as s')
                            ->select('s.id', 's.receipt_no', 's.description', 's.address', 's.phone', 's.pincode', 's.country', 's.state', 's.city', 's.status',
                                        'u.firstname', 'u.lastname', 'u.email'
                                    )
                            ->join('users as u', 'u.id', 's.user_id')
                            ->where(['s.id' => $id])
                            ->first();

            if(!empty($data)){
                $states = DB::table('state')->select('id', 'name')->where(['country_id' => $data->country])->get()->toArray();
                $cities = DB::table('city')->select('id', 'name')->where(['country_id' => $data->country, 'state_id' => $data->state])->get()->toArray();
            }

            return view('backend.subscriber.edit')->with(['data' => $data, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
        }

        public function update(SubscriberRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;
            $exst_rec = Subscriber::where(['id' => $id])->first();

            $crud = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname),
                'email' => $request->email ?? NULL,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            DB::beginTransaction();
            try {
                $update = User::where(['id' => $exst_rec->user_id])->update($crud);

                if($update){
                    $subscriber_crud = [
                        'receipt_no' => $request->receipt_no,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'pincode' => $request->pincode,
                        'country' => $request->country,
                        'state' => $request->state,
                        'city' => $request->city,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->id
                    ];

                    $subscriber_update = Subscriber::where(['id' => $id])->update($subscriber_crud);

                    if($subscriber_update){
                        DB::commit();
                        return redirect()->route('admin.subscriber')->with('success', 'Subscriber updated successfully.');
                    }else{
                        DB::rollback();
                        return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                    }
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
            $countries = Country::get();
            $states = [];
            $cities = [];

            $data = DB::table('subscribers as s')
                            ->select('s.id', 's.receipt_no', 's.description', 's.address', 's.phone', 's.pincode', 's.country', 's.state', 's.city', 's.status',
                                        'u.firstname', 'u.lastname', 'u.email'
                                    )
                            ->join('users as u', 'u.id', 's.user_id')
                            ->where(['s.id' => $id])
                            ->first();

            if(!empty($data)){
                $states = DB::table('state')->select('id', 'name')->where(['country_id' => $data->country])->get()->toArray();
                $cities = DB::table('city')->select('id', 'name')->where(['country_id' => $data->country, 'state_id' => $data->state])->get()->toArray();
            }

            return view('backend.subscriber.view')->with(['data' => $data, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $subscriber = Subscriber::where(['id' => $id])->first();

                if(!empty($subscriber)){
                    DB::beginTransaction();
                    try {
                        $update = Subscriber::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                        if($update){
                            $update_user = User::where(['id' => $subscriber->user_id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                            if($update_user){
                                DB::commit();
                                return response()->json(['code' => 200]);
                            }else{
                                DB::rollback();
                                return response()->json(['code' => 201]);
                            }
                        }else{
                            DB::rollback();
                            return response()->json(['code' => 201]);
                        }
                    } catch (\Throwable $th) {
                        DB::rollback();
                        return response()->json(['code' => 201]);
                    }
                }else{
                    return response()->json(['code' => 201]);
                }
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
