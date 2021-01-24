<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Spatie\Permission\Models\Role;
    use App\Http\Requests\ProfileRequest;
    use App\Models\User;
    use DB, Auth, Hash;

    class DashboardController extends Controller{

        public function index(Request $request){
            return view('backend.dashboard');
        }

        public function profile(Request $request){
            $data = DB::table('users as u')->select('u.id', 'u.firstname', 'u.lastname', 'u.email')->where(['u.id' => auth()->user()->id])->first();
            return view('backend.profile.profile')->with(['data' => $data]);
        }

        public function profile_edit(Request $request){
            $data = DB::table('users as u')->select('u.id', 'u.firstname', 'u.lastname', 'u.email')->where(['u.id' => auth()->user()->id])->first();
            return view('backend.profile.edit')->with(['data' => $data]);
        }

        public function profile_update(ProfileRequest $request){
            if($request->ajax()){ return true ;}

            $crud = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname)
            ];

            $update = User::where(['id' => $request->id])->update($crud);

            if($update)
                return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
            else
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
        }

        public function change_password(){
            return view('backend.profile.change_password');
        }

        public function reset_password(Request $request){
            $id = auth()->user()->id;

            $this->validate(request(), [
                'current_password' => ['required', 'string', 'max:255'],
                'new_password' => ['required', 'string', 'max:255'],
            ]);

            $user = \DB::table('users')->where(['id' => $id])->first();
            if(!Hash::check($request->current_password, $user->password)){
                return back()->with('error', 'The current password is incorrect.');
            }

            $crud = array(
                'password' => \Hash::make($request->new_password),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $update = DB::table('users')->where(['id' => $id])->limit(1)->update($crud);

            if($update){
                Auth::logout();
                return redirect()->route('admin.login')->with('success', 'Password changed successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to change password.')->withInput();
            }
        }
    }
