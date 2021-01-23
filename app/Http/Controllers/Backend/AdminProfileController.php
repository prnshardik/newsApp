<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Subscriber;
    use App\Models\User;
    use App\Models\Country;
    use App\Http\Requests\AdminProfileRequest;
    use DataTables, DB ,Auth;
    use Spatie\Permission\Models\Role;

    class AdminProfileController extends Controller{

        public function profile(Request $request,$id){

            $user = DB::table('users')->where(['id' => $id])->first();
            return view('backend.admin_profile.profile')->with(['user' => $user]);
        }

        public function profile_edit(Request $request,$id){
            $data = DB::table('users')->where(['id' => $id])->first();
            return view('backend.admin_profile.profile_edit')->with(['data' => $data]);   
        }

        public function profile_update(AdminProfileRequest $request){
            dd($request);
        }
    }
