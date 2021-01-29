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
            $total_reporters = DB::table('reporter as r')->select(DB::Raw("COUNT(".'r.id'.") as count"))->first();
            $active_reporters = DB::table('reporter as r')->select(DB::Raw("COUNT(".'r.id'.") as count"))->where(['r.status' => 'active'])->first();

            if(auth()->user()->role_id == 2){
                $total_reporters = (object) [];
                $total_reporters->count = 0;
                $active_reporters = (object) [];
                $active_reporters->count = 0;
            }

            $total_subscribers = DB::table('subscribers as s')->select(DB::Raw("COUNT(".'s.id'.") as count"))->first();
            $active_subscribers = DB::table('subscribers as s')->select(DB::Raw("COUNT(".'s.id'.") as count"))->where(['s.status' => 'active'])->first();

            if(auth()->user()->role_id == 2){
                $total_subscribers = DB::table('subscribers as s')->select(DB::Raw("COUNT(".'s.id'.") as count"))->where(['s.created_by' => auth()->user()->id])->first();
                $active_subscribers = DB::table('subscribers as s')->select(DB::Raw("COUNT(".'s.id'.") as count"))->where(['s.status' => 'active', 's.created_by' => auth()->user()->id])->first();
            }

            $agents = DB::table('reporter as r')
                            ->select('r.id', 'r.unique_id', 'r.phone_no', 'r.status',
                                        DB::Raw("CONCAT(".'u.firstname'.", ' ', ".'u.lastname'.") as name"),
                                        DB::Raw("CONCAT(".'r.receipt_book_start_no'.", ' - ', ".'r.receipt_book_end_no'.") as receipt_book_no")
                                    )
                            ->join('users as u', 'r.user_id' , 'u.id')
                            ->orderBy('id', 'desc')
                            ->limit(5)
                            ->get();

            $subscribers_collections = DB::table('subscribers as s')
                                            ->select('s.id', 's.receipt_no', 's.phone', 's.pincode', 's.status',
                                                        DB::Raw("CONCAT(".'u.firstname'.", ' ', ".'u.lastname'.") as name")
                                                    )
                                            ->join('users as u', 'u.id', 's.user_id');

            if(auth()->user()->role_id != 1)
                $subscribers_collections->where(['s.created_by' => auth()->user()->id]);

            $subscribers = $subscribers_collections->orderBy('s.id', 'desc')->limit(5)->get();

            return view('backend.dashboard', [
                                                'total_reporters' => $total_reporters, 'active_reporters' => $active_reporters,
                                                'total_subscribers' => $total_subscribers, 'active_subscribers' => $active_subscribers,
                                                'agents' => $agents, 'subscribers' => $subscribers
                                            ]);
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
