<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Talukas;
    use App\Models\Districts;
    use App\Http\Requests\TalukasRequest;
    use DataTables;
    use DB;

    class TalukasController extends Controller{
        public function __construct(){
            $this->middleware('permission:taluka-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:taluka-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:taluka-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:taluka-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('talukas as t')
                                ->select('t.id', 't.name', 'd.name as district_name', 't.status')
                                ->join('districts as d', 't.district_id', 'd.id')
                                ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('taluka-view')){
                                $return .=  '<a href="'.route('admin.taluka.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('taluka-edit')){
                                $return .= '<a href="'.route('admin.taluka.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('taluka-delete')){
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

            return view('backend.region.talukas.index');
        }

        public function create(Request $request){
            $districts = Districts::where(['status' => 'active'])->get();
            return view('backend.region.talukas.create', ['districts' => $districts]);
        }

        public function insert(TalukasRequest $request){
            if($request->ajax()){ return true; }

            $crud = [
                'name' => ucfirst($request->name),
                'district_id' => $request->district_id,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $district = Talukas::create($crud);

            if($district)
                return redirect()->route('admin.taluka')->with('success', 'Taluka inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record in taluka.')->withInput();
        }

        public function edit(Request $request){
            $id = base64_decode($request->id);
            $districts = Districts::where(['status' => 'active'])->get();
            $data = Talukas::where(['id' => $id])->first();

            return view('backend.region.talukas.edit', ['data' => $data, 'districts' => $districts]);
        }

        public function update(TalukasRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;

            $crud = [
                'name' => ucfirst($request->name),
                'district_id' => $request->district_id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $update = Talukas::where(['id' => $id])->update($crud);

            if($update)
                return redirect()->route('admin.taluka')->with('success', 'Taluka updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to update record in taluka.')->withInput();
        }

        public function view(Request $request){
            $id = base64_decode($request->id);
            $districts = Districts::where(['status' => 'active'])->get();
            $data = Talukas::where(['id' => $id])->first();

            return view('backend.region.talukas.view', ['data' => $data, 'districts' => $districts]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $district = Talukas::where(['id' => $id])->first();

                if(!empty($district)){
                    $update = Talukas::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

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
