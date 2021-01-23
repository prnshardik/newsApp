<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Country;
    use App\Models\State;
    use App\Models\City;
    use App\Http\Requests\CityRequest;
    use DataTables, DB;

    class CityController extends Controller{

        public function __construct(){
            $this->middleware('permission:city-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:city-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:city-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:city-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('city as c')
                            ->select('c.name', 'c.id', 'c.status', 'ct.name as country_name', 's.name as state_name')
                            ->join('country as ct', 'c.country_id', 'ct.id')
                            ->join('state as s', 'c.state_id', 's.id')
                            ->orderBy('c.id', 'DESC')
                            ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('city-view')){
                                $return .= '<a href="'.route('admin.city.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('city-edit')){
                                $return .=  '<a href="'.route('admin.city.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('city-delete')){
                                $return .=  '<a href="javascript:;" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
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

            return view('backend.city.index');
        }

        public function create(Request $request){
            $country = Country::all();
            $state = State::all();

            return view('backend.city.create')->with(['country' => $country ,'state' => $state]);
        }

        public function insert(CityRequest $request){
            if($request->ajax()){ return true; }

            $crud = [
                'name' => ucfirst($request->name),
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $last_id = City::insertGetId($crud);

            if($last_id > 0)
                return redirect()->route('admin.city')->with('success', 'City inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
        	$data = DB::table('city as c')
                        ->select('c.*', 's.id as state_id', 's.name as state_name', 'ct.name as country_name', 'ct.id as country_id')
                        ->join('country as ct', 'c.country_id', 'ct.id')
                        ->join('state as s', 'c.state_id', 's.id')
                        ->where(['c.id' => $id])
                        ->first();

            $country = Country::all();

            return view('backend.city.edit')->with(['data' => $data ,'country' => $country]);
        }

        public function update(CityRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;

            $crud = array(
                    'name' => ucfirst($request->name),
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => auth()->user()->id
                );

            $update = City::where(['id' => $id])->update($crud);

            if($update)
                return redirect()->route('admin.city')->with('success', 'City updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
        	$data = DB::table('city as c')
                            ->select('c.id', 'c.name', 'ct.name as country_name', 's.name as state_name')
                            ->join('country as ct' ,'c.country_id', 'ct.id')
                            ->join('state as s', 'c.state_id', 's.id')
                            ->where(['c.id' => $id])
                            ->first();

            return view('backend.city.view')->with(['data' => $data]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $update = City::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                if($update)
                    return response()->json(['code' => 200]);
                else
                    return response()->json(['code' => 201]);
            }else{
                return response()->json(['code' => 201]);
            }
        }

        public function get_state(Request $request){
            $country_id = $request->country_id;

            $data = State::select('id', 'name')->where(['country_id' => $country_id])->get();

            if(isset($data) && $data->isNotEmpty()){
                $html = '<option value="">select state</option>';
                foreach($data as $row){
                    $html .= "<option value='".$row->id."'>".$row->name."</option>";
                }
                return response()->json(['code' => 200, 'data' => $html]);
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
