<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Reporter;
    use App\Models\State;
    use App\Models\City;
    use App\Http\Requests\ReporterRequest;
    use DataTables, DB;

    class ReporterController extends Controller{

        public function __construct(){
            $this->middleware('permission:reporter-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:reporter-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:reporter-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:reporter-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('reporter AS r')
                        ->select('r.*')
                        ->orderBy('r.id' ,'DESC')
                        ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('reporter-view')){
                                $return .=  '<a href="'.route('admin.country.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('reporter-edit')){
                                $return .= '<a href="'.route('admin.country.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
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
            $country = DB::table('country')->where(['status' => 'active'])->get();
            return view('backend.reporter.create')->with(['country' => $country]);
        }

        public function insert(ReporterRequest $request){
            if($request->ajax()){ return true; }

            $crud = [
                'name' => ucfirst($request->name),
                'unique_id' => $request->unique_id,
                'address' => $request->address,
                'phone_no' => $request->phone_no,
                'email' => $request->email,
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

            $last_id = Reporter::insertGetId($crud);

            if($last_id > 0)
                return redirect()->route('admin.reporter')->with('success', 'Record inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
            $data = Country::find($id);

            return view('backend.reporter.edit')->with(['data' => $data]);
        }

        public function update(CountryRequest $request){
        	if($request->ajax()){ return true ;}

            $crud = [
                'name' => ucfirst($request->name),
                'country_code' => $request->country_code,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $update = Reporter::where(['id' => $request->id])->update($crud);

            if($update)
                return redirect()->route('admin.reporter')->with('success', 'Record updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
            $data = DB::table('reporter')
                        ->select('reporter.*' ,'c.name AS country_name' ,'s.name AS state_name' ,'ct.name AS city_name')
                        ->join('country AS c' , 'reporter.country_id' ,'c.id')
                        ->join('state AS s' , 'reporter.state_id' ,'s.id')
                        ->join('city AS c' , 'reporter.city_id' ,'c.id')
                        ->where(['reporter.id' => $id])
                        ->first();

            return view('backend.reporter.view')->with(['data' => $data]);
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

        public function get_city(Request $request){
            $state_id = $request->state_id;

            $data = City::select('id', 'name')->where(['state_id' => $state_id])->get();

            if(isset($data) && $data->isNotEmpty()){
                $html = '<option value="">select City</option>';
                foreach($data as $row){
                    $html .= "<option value='".$row->id."'>".$row->name."</option>";
                }
                return response()->json(['code' => 200, 'data' => $html]);
            }else{
                return response()->json(['code' => 201]);
            }
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
