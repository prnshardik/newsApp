<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Country;
    use App\Http\Requests\CountryRequest;
    use DataTables, DB;

    class CountryController extends Controller{
        public function index(Request $request){
        	if($request->ajax()){
                $data = Country::select('id', 'name', 'country_code', 'status')->orderBy('id' ,'DESC')->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            return '<div class="btn-group">
                                        <a href="'.route('admin.country.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;
                                        <a href="'.route('admin.country.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
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
                                return '<span class="badge badge-success">Active</span>';
                            }else if($data->status == 'inactive'){
                                return '<span class="badge badge-warning">Inactive</span>';
                            }else if($data->status == 'deleted'){
                                return '<span class="badge badge-danger">Delete</span>';
                            }else{
                                return '-';
                            }
                        })

                        ->rawColumns(['action', 'status'])
                        ->make(true);
            }

            return view('backend.country.index');
        }

        public function create(Request $request){
            return view('backend.country.create');
        }

        public function insert(CountryRequest $request){
            if($request->ajax()){ return true; }

            $crud = [
                'name' => ucfirst($request->name),
                'country_code' => $request->country_code,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $last_id = Country::insertGetId($crud);

            if($last_id > 0)
                return redirect()->route('admin.country')->with('success', 'Country inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
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
