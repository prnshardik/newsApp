<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Spatie\Permission\Models\Role;
    use App\Http\Requests\RoleRequest;
    use DataTables;
    use Spatie\Permission\Models\Permission;
    use DB;

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
            $permissions = Permission::get();
            return view('backend.role.create', ['permissions' => $permissions]);
        }

        public function insert(RoleRequest $request){
            if($request->ajax()){ return true; }

            $curd = [
                'name' => $request->name,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $role = Role::create($curd);
            if($role){
                $role->syncPermissions($request->permissions);

                return redirect()->route('admin.role')->with('success', 'Role inserted successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
            $data = Role::find($id);
            $permissions = Permission::get();
            $role_permissions = DB::table("role_has_permissions")
                                    ->where("role_has_permissions.role_id", $id)
                                    ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                    ->all();

            return view('backend.role.edit')->with(['data' => $data, 'permissions' => $permissions, 'role_permissions' => $role_permissions]);
        }

        public function update(RoleRequest $request){
            if($request->ajax()){ return true ;}

            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->updated_at = date('Y-m-d H:i:s');

            if($role->save()){
                $role->syncPermissions($request->permissions);

                return redirect()->route('admin.role')->with('success', 'Role updated successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to update record.')->withInput();
            }
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);
            $data = Role::find($id);
            $permissions = Permission::get();
            $role_permissions = DB::table("role_has_permissions")
                                    ->where("role_has_permissions.role_id", $id)
                                    ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                    ->all();

            return view('backend.role.view')->with(['data' => $data, 'permissions' => $permissions, 'role_permissions' => $role_permissions]);
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
