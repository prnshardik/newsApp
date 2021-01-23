<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Permission;
    use App\Http\Requests\PermissionRequest;
    use DataTables;

    class PermissionController extends Controller{

        public function __construct(){
            $this->middleware('permission:permission-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:permission-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:permission-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $data = Permission::select('id', 'name', 'guard_name')->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('permission-view')){
                                $return .= '<a href="'.route('admin.permission.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('permission-edit')){
                                $return .= '<a href="'.route('admin.permission.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('permission-delete')){
                                $return .= '<a class="btn btn-default btn-xs" href="javascript:void(0);" onclick="delete_func(this);" data-id="'.$data->id.'">
                                                <i class="fa fa-trash"></i>
                                            </a> &nbsp;';
                            }

                            $return .= '</div>';

                            return $return;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }

            return view('backend.permission.index');
        }

        public function create(Request $request){
            return view('backend.permission.create');
        }

        public function insert(PermissionRequest $request){
            if($request->ajax()){ return true; }

            $curd = [
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $last_id = Permission::insertGetId($curd);

            if($last_id > 0)
                return redirect()->route('admin.permission')->with('success', 'Permission inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
        	$data = Permission::find($id);
            return view('backend.permission.edit')->with(['data' => $data]);
        }

        public function update(PermissionRequest $request){
            if($request->ajax()){ return true ;}

            $curd = [
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $update = Permission::where(['id' => $request->id])->update($curd);

            if($update)
                return redirect()->route('admin.permission')->with('success', 'Permission updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to update record.')->withInput();
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
        	$data = Permission::find($id);
            return view('backend.permission.view')->with(['data' => $data]);
        }

        public function delete(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = $request->id;
                $delete = Permission::where(['id' => $id])->delete();

                if($delete)
                    return response()->json(['code' => 200]);
                else
                    return response()->json(['code' => 201]);
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
