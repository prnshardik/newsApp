<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Country;
    use App\Models\Reporter;
    use App\Http\Requests\UserProfileRequest;
    use DataTables, DB ,Auth;
    use Spatie\Permission\Models\Role;

    class UserProfileController extends Controller{

        public function profile(Request $request,$id){

            $user = DB::table('reporter AS r')
                        ->select('r.*' ,'users.*' ,'c.name AS country_name' ,'s.name AS state_name' ,'ct.name AS city_name')
                        ->join('users' ,'r.user_id' ,'users.id')
                        ->join('country AS c' ,'r.country_id' ,'c.id')
                        ->join('state AS s' ,'r.state_id' ,'s.id')
                        ->join('city AS ct' ,'r.city_id' ,'ct.id')
                        ->where(['users.id' => $id])
                        ->first();
            
            return view('backend.user_profile.profile')->with(['user' => $user]);
        }

        public function profile_edit(Request $request,$id){
            $countries = DB::table('country')->where(['status' => 'active'])->get();
            $states = [];
            $cities = [];
            DB::enableQueryLog();
            $data = DB::table('reporter as r')
                            ->select('r.id', 'r.unique_id', 'r.address', 'r.phone_no', 'r.receipt_book_start_no', 'r.receipt_book_end_no', 'r.country_id', 'r.state_id',
                                        'r.city_id', 'r.status', 'u.firstname', 'u.lastname', 'u.email'
                                    )
                            ->join('users as u', 'r.user_id', 'u.id')
                            ->where(['u.id' => $id])
                            ->first();
            // dd(DB::getQueryLog());
            if(!empty($data)){
                $states = DB::table('state')->select('id', 'name')->where(['country_id' => $data->country_id])->get()->toArray();
                $cities = DB::table('city')->select('id', 'name')->where(['country_id' => $data->country_id, 'state_id' => $data->state_id])->get()->toArray();
            }

            return view('backend.user_profile.profile_edit')->with(['data' => $data, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);   
        }

        public function profile_update(UserProfileRequest $request){
            if($request->ajax()){ return true ;}

             $id = $request->id;
            $exst_rec = Reporter::where(['id' => $id])->first();

            $crud = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            DB::beginTransaction();
            try {
                $update = User::where(['id' => $exst_rec->user_id])->update($crud);

                if($update){
                    $reporter_crud = [
                        'address' => $request->address,
                        'phone_no' => $request->phone_no,
                        'country_id' => $request->country_id,
                        'state_id' => $request->state_id,
                        'city_id' => $request->city_id,
                        'status' => 'active',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->id
                    ];

                    $reporter_update = Reporter::where(['id' => $id])->update($reporter_crud);

                
                    if($reporter_update){
                        DB::commit();
                        return redirect()->route('admin.dashboard')->with('success', 'Record updated successfully.');
                    }else{
                        DB::rollback();
                        return redirect()->back()->with('error', 'Failed to update record in reporter.')->withInput();
                    }
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to update record in user.')->withInput();
                }
            } catch (\Throwable $th) {
                
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to update record.')->withInput();
            }
        }
    }
