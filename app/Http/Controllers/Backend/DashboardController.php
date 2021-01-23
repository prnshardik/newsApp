<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Spatie\Permission\Models\Role;

    class DashboardController extends Controller{

        public function index(Request $request){
            return view('backend.dashboard');
        }
    }
