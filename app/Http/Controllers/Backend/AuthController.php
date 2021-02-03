<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use Illuminate\Support\Str;
    use App\Mail\ForgetPassword;
    use Auth, Validator, DB, Mail;

    class AuthController extends Controller{

        public function login(Request $request){
            return view('backend.auth.login');
        }

        public function signin(Request $request){
            $validator = Validator::make(
                                        ['email' => $request->email, 'password' => $request->password],
                                        ['email' => 'required', 'password' => 'required']
                                    );

            if($validator->fails()){
                return redirect()->route('admin.login')->withErrors($validator)->withInput();
            }else{
                $auth = auth()->attempt(['email' => $request->email, 'password' => $request->password]);

                if($auth != false){
                    $user = User::where(['email' => $request->email])->orderBy('id', 'desc')->first();

                    if($user->role_id != 1 && $user->role_id != 2){
                        Auth::logout();
                        return redirect()->route('admin.login')->with('error', 'This account type is not have permission to login, please contact administrator');
                    }

                    if($user->status == 'inactive'){
                        Auth::logout();
                        return redirect()->route('admin.login')->with('error', 'Account belongs to this credentials is inactive, please contact administrator');
                    }elseif($user->status == 'deleted'){
                        Auth::logout();
                        return redirect()->route('admin.login')->with('error', 'Account belongs to this credentials is deleted, please contact administrator');
                    }else{
                        return redirect()->route('admin.dashboard')->with('success', 'Login successfully');
                    }
                }else{

                    $reporter = DB::table('reporter As r')->select('u.email')->leftJoin('users AS u' ,'r.user_id' ,'u.id')->where(['r.unique_id' => $request->email])->first();

                    if($reporter){
                        $auth = auth()->attempt(['email' => $reporter->email, 'password' => $request->password]);
                    }else{
                        $auth = false;
                    }
                    
                    if($auth != false){
                    $user = User::where(['email' => $reporter->email])->orderBy('id', 'desc')->first();

                        if($user->role_id != 1 && $user->role_id != 2){
                            Auth::logout();
                            return redirect()->route('admin.login')->with('error', 'This account type is not have permission to login, please contact administrator');
                        }

                        if($user->status == 'inactive'){
                            Auth::logout();
                            return redirect()->route('admin.login')->with('error', 'Account belongs to this credentials is inactive, please contact administrator');
                        }elseif($user->status == 'deleted'){
                            Auth::logout();
                            return redirect()->route('admin.login')->with('error', 'Account belongs to this credentials is deleted, please contact administrator');
                        }else{
                            return redirect()->route('admin.dashboard')->with('success', 'Login successfully');
                        }
                    }else{
                        return redirect()->route('admin.login')->with('error', 'invalid credentials, please check credentials');
                    }
                }
            }
        }

        public function logout(Request $request){
            Auth::logout();
            return redirect()->route('admin.login');
        }

        public function forget_password(Request $request){
            return view('backend.auth.forget-password');
        }

        public function password_forget(Request $request){
            $user = DB::table('users')->where(['email' => $request->email])->first();

            if(!isset($user) && $user == null) {
                return redirect()->back()->withErrors(['email' => 'Entered email address does not exists in records, please check email address']);
            }

            $token = Str::random(60);
            $link = url('/reset-password').'/'.$token.'?email='.urlencode($user->email);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $mailData = array('from_email' => config('constants.from_email'), 'email' => $request->email, 'link' => $link, 'logo' => url('/backend/img/image.jpg'));
            Mail::to($request->email)->send(new ForgetPassword($mailData));

            return redirect()->route('admin.forget.password.page', $request->email);
        }

        public function forget_password_page($mail){
            return view('backend.auth.forget_password_page', compact('mail'));
        }

        public function reset_password(Request $request, $string){
            $email = $request->email;
            return view('backend.auth.reset_password', compact('email', 'string'));
        }

        public function recover_password(Request $request){
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required',
                'token' => 'required'
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $tokenData = \DB::table('password_resets')->where('token', $request->token)->OrderBy('created_at', 'desc')->first();

            if(!isset($tokenData) && $tokenData == null){
                return redirect()->route('admin.login')->with('error', 'reset password token mismatch, please regenerate link again')->withInput();
            }

            $user = \DB::table('users')->where('email', $request->email)->first();

            if(!isset($user) && $user == null){
                return redirect()->back()->with('error', 'email address does not exists, please check email address')->withInput();
            }

            $crud = array(
                'password' => \Hash::make($request->password),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            DB::table('users')->where('email', $request->email)->limit(1)->update($crud);

            DB::table('password_resets')->where('email', $user->email)->delete();

            return redirect()->route('admin.login')->with('success', 'Password resetted successgully');
        }
    }
