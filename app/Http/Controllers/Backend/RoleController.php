<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Role;
    use App\Http\Requests\RoleRequest;
    use DataTables;

    class RoleController extends Controller{
        public function index(Request $request){
        	if($request->ajax()){
                $data = Role::select('id', 'name', 'guard_name')->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            return '<div class="btn-group">
                                        <a href="'.route('admin.role.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;
                                        <a href="'.route('admin.role.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a> &nbsp;
                                        <a class="btn btn-default btn-xs" href="javascript:void(0);" onclick="delete_func(this);" data-id="'.$data->id.'">
                                            <i class="fa fa-trash"></i>
                                        </a> &nbsp;
                                    </div>';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }

            return view('backend.role.index');
        }

        public function create(Request $request){
            return view('backend.role.create');
        }

        public function insert(RoleRequest $request){
            if($request->ajax()){ return true; }

            $curd = [
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $last_id = Role::insertGetId($curd);

            if($last_id > 0)
                return redirect()->route('admin.role')->with('success', 'Role inserted successfully.');
            else
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
        	$data = Role::find($id);
            return view('backend.role.edit')->with(['data' => $data]);
        }

        public function update(RoleRequest $request){
            if($request->ajax()){ return true ;}

            $curd = [
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $update = Role::where(['id' => $request->id])->update($curd);

            if($update)
                return redirect()->route('admin.role')->with('success', 'Role updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to update record.')->withInput();
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
        	$data = Role::find($id);
            return view('backend.role.view')->with(['data' => $data]);
        }

        public function delete(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = $request->id;
                $delete = Role::where(['id' => $id])->delete();

                if($delete)
                    return response()->json(['code' => 200]);
                else
                    return response()->json(['code' => 201]);
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
