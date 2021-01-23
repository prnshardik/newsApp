<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Reporter;
    use App\Models\Country;
    use App\Models\State;
    use App\Models\City;
    use App\Models\User;
    use App\Http\Requests\ReporterRequest;
    use DataTables, DB;
    use Spatie\Permission\Models\Role;
    use Hash;

    class ReporterController extends Controller{

        public function __construct(){
            $this->middleware('permission:reporter-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:reporter-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:reporter-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:reporter-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('reporter as r')
                            ->join('users as u', 'r.user_id' , 'u.id')
                            ->join('state as st', 'st.id', 'r.state_id')
                            ->join('city as ct', 'ct.id', 'r.city_id')
                            ->select('r.id', 'r.unique_id', 'r.phone_no', 'r.status',
                                        DB::Raw("CONCAT(".'u.firstname'.", ' ', ".'u.lastname'.") as name"), 
                                        DB::Raw("CONCAT(".'r.receipt_book_start_no'.", ' ', ".'r.receipt_book_end_no'.") as receipt_book_no"),
                                        'ct.name as city_name', 'st.name as state_name'
                                    )
                            ->orderBy('id', 'desc')
                            ->get();
                
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('reporter-view')){
                                $return .=  '<a href="'.route('admin.reporter.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('reporter-edit')){
                                $return .= '<a href="'.route('admin.reporter.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('reporter-delete')){
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

            return view('backend.reporter.index');
        }

        public function create(Request $request){
            $countries = DB::table('country')->where(['status' => 'active'])->get();
            return view('backend.reporter.create')->with(['countries' => $countries]);
        }

        public function insert(ReporterRequest $request){
            if($request->ajax()){ return true; }

            $role_id = 2;
            $password = 'abcd1234';

            if($request->password != '' && $request->password != NULL){
                $password = $request->password;
            }

            $crud = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname),
                'email' => $request->email,
                'role_id' => $role_id,
                'status' => 'active',
                'password' => bcrypt($password),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];
            // dd($request);
            DB::beginTransaction();
            try {
                $user = User::create($crud);

                if($user){
                    $reporter_crud = [
                        'user_id' => $user->id,
                        'unique_id' => $request->unique_id,
                        'address' => $request->address,
                        'phone_no' => $request->phone_no,
                        'country_id' => $request->country_id,
                        'state_id' => $request->state_id,
                        'city_id' => $request->city_id,
                        'receipt_book_start_no' => $request->receipt_book_start_no,
                        'receipt_book_end_no' => $request->receipt_book_end_no,
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => auth()->user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->id
                    ];

                    $reporter_last_id = Reporter::insertGetId($reporter_crud);

                    if($reporter_last_id > 0){
                        $user->assignRole($role_id);

                        DB::commit();
                        return redirect()->route('admin.reporter')->with('success', 'Record inserted successfully.');
                    }else{
                        DB::rollback();
                        return redirect()->back()->with('error', 'Failed to insert record in reporter.')->withInput();
                    }
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to insert record in user.')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }

        public function edit(Request $request){
            $id = base64_decode($request->id);
            $countries = DB::table('country')->where(['status' => 'active'])->get();
            $states = [];
            $cities = [];

            $data = DB::table('reporter as r')
                            ->select('r.id', 'r.unique_id', 'r.address', 'r.phone_no', 'r.receipt_book_start_no', 'r.receipt_book_end_no', 'r.country_id', 'r.state_id',
                                        'r.city_id', 'r.status', 'u.firstname', 'u.lastname', 'u.email'
                                    )
                            ->join('users as u', 'u.id', 'r.user_id')
                            ->where(['r.id' => $id])
                            ->first();

            if(!empty($data)){
                $states = DB::table('state')->select('id', 'name')->where(['country_id' => $data->country_id])->get()->toArray();
                $cities = DB::table('city')->select('id', 'name')->where(['country_id' => $data->country_id, 'state_id' => $data->state_id])->get()->toArray();
            }

            return view('backend.reporter.edit')->with(['data' => $data, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
        }

        public function update(ReporterRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;
            $exst_rec = Reporter::where(['id' => $id])->first();

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
                    $reporter_crud = [
                        'unique_id' => $request->unique_id,
                        'address' => $request->address,
                        'phone_no' => $request->phone_no,
                        'country_id' => $request->country_id,
                        'state_id' => $request->state_id,
                        'city_id' => $request->city_id,
                        'receipt_book_start_no' => $request->receipt_book_start_no,
                        'receipt_book_end_no' => $request->receipt_book_end_no,
                        'status' => 'active',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->id
                    ];

                    $reporter_update = Reporter::where(['id' => $id])->update($reporter_crud);

                    if($reporter_update){
                        DB::commit();
                        return redirect()->route('admin.reporter')->with('success', 'Record updated successfully.');
                    }else{
                        DB::rollback();
                        return redirect()->back()->with('error', 'Failed to update record in reporter.')->withInput();
                    }
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to update record in user.')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to update record.')->withInput();
            }
        }

        public function view(Request $request){
            $id = base64_decode($request->id);
            $countries = DB::table('country')->where(['status' => 'active'])->get();
            $states = [];
            $cities = [];

            $data = DB::table('reporter as r')
                            ->select('r.id', 'r.unique_id', 'r.address', 'r.phone_no', 'r.receipt_book_start_no', 'r.receipt_book_end_no', 'r.country_id', 'r.state_id',
                                        'r.city_id', 'r.status', 'u.firstname', 'u.lastname', 'u.email'
                                    )
                            ->join('users as u', 'u.id', 'r.user_id')
                            ->where(['r.id' => $id])
                            ->first();

            if(!empty($data)){
                $states = DB::table('state')->select('id', 'name')->where(['country_id' => $data->country_id])->get()->toArray();
                $cities = DB::table('city')->select('id', 'name')->where(['country_id' => $data->country_id, 'state_id' => $data->state_id])->get()->toArray();
            }

            return view('backend.reporter.view')->with(['data' => $data, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $reporter = Reporter::where(['id' => $id])->first();

                if(!empty($reporter)){
                    DB::beginTransaction();
                    try {
                        $update = Reporter::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                        if($update){
                            $update_user = User::where(['id' => $reporter->user_id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

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
