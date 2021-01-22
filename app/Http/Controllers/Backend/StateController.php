<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Country;
    use App\Models\State;
    use App\Http\Requests\StateRequest;
    use DataTables, DB;

    class StateController extends Controller{
        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('state as s')
                            ->select('s.id', 's.name', 's.status', 'c.name as country_name')
                            ->join('country as c', 's.country_id', 'c.id')
                            ->orderBy('s.id', 'DESC')
                            ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            return '<div class="btn-group">
                                        <a href="'.route('admin.state.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;
                                        <a href="'.route('admin.state.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a> &nbsp;
                                        <a href="javascript:;" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="active" data-id="'.base64_encode($data->id).'">Active</a></li>
                                            <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="inactive" data-id="'.base64_encode($data->id).'">Inactive</a></li>
                                            <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="deleted" data-id="'.base64_encode($data->id).'">Delete</a></li>
                                        </ul>
                                    </div>';
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

            return view('backend.state.index');
        }

        public function create(Request $request){
            $country = Country::all();
            return view('backend.state.create')->with(['country' => $country]);
        }

        public function insert(StateRequest $request){
            if($request->ajax()){ return true; }

            $crud = [
                'name' => ucfirst($request->name),
                'country_id' => $request->country_id,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $last_id = State()::insertGetId($crud);

            if($last_id > 0)
                return redirect()->route('admin.state')->with('success', 'State inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
        	$data = State::find($id);
            $country = Country::all();

            return view('backend.state.edit')->with(['data' => $data , 'country' => $country]);
        }

        public function update(StateRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;

            $crud = [
                    'name' => ucfirst($request->name),
                    'country_id' => $request->country_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => auth()->user()->id
            ];

            $update = DB::table('state')->where(['id' => $id])->update($crud);

            if($update)
                return redirect()->route('admin.state')->with('success', 'State updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);

            $data = DB::table('state as s')
                        ->select('s.id', 's.name', 'c.name as country_name')
                        ->join('country as c', 's.country_id', 'c.id')
                        ->where(['s.id' => $id])
                        ->first();

            return view('backend.state.view')->with(['data' => $data]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $update = State::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                if($update)
                    return response()->json(['code' => 200]);
                else
                    return response()->json(['code' => 201]);
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
