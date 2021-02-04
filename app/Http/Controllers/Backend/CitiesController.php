<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Districts;
    use App\Models\Talukas;
    use App\Models\Cities;
    use App\Http\Requests\CitiesRequest;
    use DataTables;
    use DB;

    class CitiesController extends Controller{
        public function __construct(){
            $this->middleware('permission:city-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:city-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:city-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:city-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('cities as c')
                                ->select('c.id', 'c.name', 'c.pincode', 'c.status', 't.name as taluka_name', 'd.name as district_name')
                                ->leftjoin('districts as d', 'd.id', 'c.district_id')
                                ->leftjoin('talukas as t', 't.id', 'c.taluka_id')
                                ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('city-view')){
                                $return .=  '<a href="'.route('admin.city.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('city-edit')){
                                $return .= '<a href="'.route('admin.city.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('city-delete')){
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

            return view('backend.region.cities.index');
        }

        public function create(Request $request){
            $districts = Districts::where(['status' => 'active'])->get();
            return view('backend.region.cities.create', ['districts' => $districts]);
        }

        public function insert(CitiesRequest $request){
            if($request->ajax()){ return true; }

            $crud = [
                'name' => ucfirst($request->name),
                'pincode' => $request->pincode ?? null,
                'district_id' => $request->district_id,
                'taluka_id' => $request->taluka_id,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $city = Cities::create($crud);

            if($city)
                return redirect()->route('admin.city')->with('success', 'City inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record in city.')->withInput();
        }

        public function edit(Request $request){
            $id = base64_decode($request->id);
            $districts = Districts::where(['status' => 'active'])->get();
            $talukas = [];
            $data = Cities::where(['id' => $id])->first();

            if($data){
                $talukas = Talukas::where(['status' => 'active', 'district_id' => $data->district_id])->get()->toArray();
            }

            return view('backend.region.cities.edit')->with(['data' => $data, 'districts' => $districts, 'talukas' => $talukas]);
        }

        public function update(CitiesRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;

            $crud = [
                'name' => ucfirst($request->name),
                'pincode' => $request->pincode ?? null,
                'district_id' => $request->district_id,
                'taluka_id' => $request->taluka_id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $update = Cities::where(['id' => $id])->update($crud);

            if($update)
                return redirect()->route('admin.city')->with('success', 'City updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to update record in city.')->withInput();
        }

        public function view(Request $request){
            $id = base64_decode($request->id);
            $districts = Districts::where(['status' => 'active'])->get();
            $talukas = [];
            $data = Cities::where(['id' => $id])->first();

            if($data){
                $talukas = Talukas::where(['status' => 'active', 'district_id' => $data->district_id])->get()->toArray();
            }

            return view('backend.region.cities.view')->with(['data' => $data, 'districts' => $districts, 'talukas' => $talukas]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $city = Cities::where(['id' => $id])->first();

                if(!empty($city)){
                    $update = Cities::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

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

        public function get_talukas(Request $request){
            $district_id = $request->district_id;

            $data = Talukas::select('id', 'name')->where(['district_id' => $district_id])->get();

            if(isset($data) && $data->isNotEmpty()){
                $html = '<option value="">Select Taluka</option>';
                foreach($data as $row){
                    $html .= "<option value='".$row->id."'>".$row->name."</option>";
                }
                return response()->json(['code' => 200, 'data' => $html]);
            }else{
                return response()->json(['code' => 201]);
            }
        }

        public function get_cities(Request $request){
            $taluka_id = $request->taluka_id;

            $data = Cities::select('id', 'name', 'pincode')->where(['taluka_id' => $taluka_id])->get();

            if(isset($data) && $data->isNotEmpty()){
                $html = '<option value="">Select City</option>';
                foreach($data as $row){
                    $html .= "<option value='".$row->id."' data-id='".$row->pincode."'>".$row->name."</option>";
                }
                return response()->json(['code' => 200, 'data' => $html]);
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
