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
                // $data = Subscriber::select('id', 'name', 'country_code', 'status')->orderBy('id', 'DESC')->get();
                $data  = [];
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
            $data = Country::find($id);

            return view('backend.country.edit')->with(['data' => $data]);
        }

        public function update(CountryRequest $request){
        	if($request->ajax()){ return true ;}

            $crud = [
                'name' => ucfirst($request->name),
                'country_code' => $request->country_code,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $update = Country::where(['id' => $request->id])->update($crud);

            if($update)
                return redirect()->route('admin.country')->with('success', 'Country updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
            $data = Country::find($id);

            return view('backend.country.view')->with(['data' => $data]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $update = Country::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                if($update)
                    return response()->json(['code' => 200]);
                else
                    return response()->json(['code' => 201]);
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
