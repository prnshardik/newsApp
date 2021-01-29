<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Subscriber;
    use App\Models\User;
    use App\Models\Country;
    use App\Http\Requests\SubscriberRequest;
    use DataTables, DB ,PDF;
    use Spatie\Permission\Models\Role;
    use App\Exports\SubscriberExport;
    use Maatwebsite\Excel\Facades\Excel;

    class SubscriberController extends Controller{

        public function __construct(){
            $this->middleware('permission:subscriber-create', ['only' => ['create', 'insert']]);
            $this->middleware('permission:subscriber-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:subscriber-view', ['only' => ['index', 'change_status']]);
            $this->middleware('permission:subscriber-delete', ['only' => ['change_status']]);
        }

        public function index(Request $request){
        	if($request->ajax()){
                $collections = DB::table('subscribers as s')
                                    ->select('s.id', 's.receipt_no', 's.phone', 's.pincode', 's.status',
                                                DB::Raw("CONCAT(".'u.firstname'.", ' ', ".'u.lastname'.") as name")
                                            )
                                    ->join('users as u', 'u.id', 's.user_id');

                if(auth()->user()->role_id != 1)
                    $collections->where(['s.created_by' => auth()->user()->id]);

                $data = $collections->orderBy('s.id', 'desc')
                                    ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            $return = '<div class="btn-group">';

                            if(auth()->user()->can('subscriber-view')){
                                $return .=  '<a href="'.route('admin.subscriber.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('subscriber-edit')){
                                $return .= '<a href="'.route('admin.subscriber.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a> &nbsp;';
                            }

                            if(auth()->user()->can('subscriber-delete')){
                                $return .= '<a href="javascript:;" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-bars"></i>
                                            </a> &nbsp;
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="active" data-old_status="'.$data->status.'" data-id="'.base64_encode($data->id).'">Active</a></li>

                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="block" data-old_status="'.$data->status.'" data-id="'.base64_encode($data->id).'">Block</a></li>

                                                <li><a class="dropdown-item" href="javascript:;" onclick="change_status(this);" data-status="deleted" data-old_status="'.$data->status.'" data-id="'.base64_encode($data->id).'">Delete</a></li>
                                            </ul>';
                            }

                            $return .= '</div>';

                            return $return;
                        })

                        ->editColumn('status', function($data) {
                            if($data->status == 'active'){
                                return '<span class="badge badge-pill badge-success">Active</span>';
                            }else if($data->status == 'inactive'){
                                return '<span class="badge badge-pill badge-primary">Inactive</span>';
                            }else if($data->status == 'deleted'){
                                return '<span class="badge badge-pill badge-danger">Delete</span>';
                            }else if($data->status == 'block'){
                                return '<span class="badge badge-pill badge-warning">Block</span>';
                            }else{
                                return '-';
                            }
                        })

                        ->rawColumns(['action', 'status'])
                        ->make(true);
            }

            $reporters = DB::table('reporter as r')->select(['u.id', 'u.firstname', 'u.lastname'])
                                ->leftjoin('users as u', 'u.id', 'r.user_id')
                                ->get();

            return view('backend.subscriber.index', ['reporters' => $reporters]);
        }

        public function create(Request $request){
            $receipt_no = '';

            if(auth()->user()->id != 1){
                $reporter = DB::table('reporter')
                                    ->select('receipt_book_start_no', 'receipt_book_end_no')
                                    ->where(['user_id' => auth()->user()->id])
                                    ->first();

                $subscribers = DB::table('subscribers')
                                    ->select('receipt_no')
                                    ->where(['created_by' => auth()->user()->id])
                                    ->orderBy('id', 'desc')
                                    ->first();

                if(empty($subscribers)){
                    $receipt_no = $reporter->receipt_book_start_no;
                }else{
                    if($subscribers->receipt_no >= $reporter->receipt_book_start_no && $subscribers->receipt_no < $reporter->receipt_book_end_no){
                        $receipt_no = $subscribers->receipt_no + 1;
                    }else{
                        if($subscribers->receipt_no < $reporter->receipt_book_end_no){
                            $receipt_no = $reporter->receipt_book_start_no;
                        }else{
                            return redirect()->back()->with(['error' => 'your reciept book is completed, please contact administrator']);
                        }
                    }
                }
            }

            return view('backend.subscriber.create', ['receipt_no' => $receipt_no]);
        }

        public function insert(SubscriberRequest $request){
            if($request->ajax()){ return true; }

            $role_id = 3;
            $crud = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname),
                'email' => $request->email ?? NULL,
                'role_id' => $role_id,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            DB::beginTransaction();
            try {
                $user = User::create($crud);

                if($user){
                    $subscriber_crud = [
                        'user_id' => $user->id,
                        'receipt_no' => $request->receipt_no,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'pincode' => $request->pincode,
                        'magazine' => $request->magazine,
                        'end_date' => date('Y-m-d', strtotime('+1 year')),
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => auth()->user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->id
                    ];

                    $subscriber_last_id = Subscriber::insertGetId($subscriber_crud);

                    if($subscriber_last_id > 0){
                        $user->assignRole($role_id);

                        DB::commit();
                        return redirect()->route('admin.subscriber')->with('success', 'Subscriber inserted successfully.');
                    }else{
                        DB::rollback();
                        return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                    }
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);

            $data = DB::table('subscribers as s')
                            ->select('s.id', 's.receipt_no', 's.description', 's.address', 's.phone', 's.pincode', 's.status',
                                        'u.firstname', 'u.lastname', 'u.email', 's.magazine'
                                    )
                            ->join('users as u', 'u.id', 's.user_id')
                            ->where(['s.id' => $id])
                            ->first();

            return view('backend.subscriber.edit')->with(['data' => $data]);
        }

        public function update(SubscriberRequest $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;
            $exst_rec = Subscriber::where(['id' => $id])->first();

            $crud = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname),
                'email' => $request->email ?? NULL,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            DB::beginTransaction();
            try {
                $update = User::where(['id' => $exst_rec->user_id])->update($crud);

                if($update){
                    $subscriber_crud = [
                        'receipt_no' => $request->receipt_no,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'pincode' => $request->pincode,
                        'magazine' => $request->magazine,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => auth()->user()->id
                    ];

                    $subscriber_update = Subscriber::where(['id' => $id])->update($subscriber_crud);

                    if($subscriber_update){
                        DB::commit();
                        return redirect()->route('admin.subscriber')->with('success', 'Subscriber updated successfully.');
                    }else{
                        DB::rollback();
                        return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                    }
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }

        public function view(Request $request){
        	$id = base64_decode($request->id);

            $data = DB::table('subscribers as s')
                            ->select('s.id', 's.receipt_no', 's.description', 's.address', 's.phone', 's.pincode', 's.status',
                                        'u.firstname', 'u.lastname', 'u.email', 's.magazine'
                                    )
                            ->join('users as u', 'u.id', 's.user_id')
                            ->where(['s.id' => $id])
                            ->first();

            return view('backend.subscriber.view')->with(['data' => $data]);
        }

        public function change_status(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = base64_decode($request->id);
                $status = $request->status;

                $subscriber = Subscriber::where(['id' => $id])->first();

                if(!empty($subscriber)){
                    DB::beginTransaction();
                    try {
                        if($status == 'active'){
                            $update = Subscriber::where(['id' => $id])->update(['status' => $status, 'end_date' => date('Y-m-d', strtotime('+1 year')), 'updated_by' => auth()->user()->id]);
                        }else{
                            $update = Subscriber::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);
                        }

                        if($update){
                            if($status != 'block'){
                                $update_user = User::where(['id' => $subscriber->user_id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                                if($update_user){
                                    DB::commit();
                                    return response()->json(['code' => 200]);
                                }else{
                                    DB::rollback();
                                    return response()->json(['code' => 201]);
                                }
                            }else{
                                DB::commit();
                                return response()->json(['code' => 200]);
                            }
                        }else{
                            DB::rollback();
                            return response()->json(['code' => 201]);
                        }
                    } catch (\Throwable $th) {
                        DB::rollback();
                        return response()->json(['code' => 201]);
                    }
                }else{
                    return response()->json(['code' => 201]);
                }
            }else{
                return response()->json(['code' => 201]);
            }
        }

        public function filter(Request $request){
            if(auth()->user()->role_id != 1){
                return redirect()->back()->with(['error' => 'you don\'t have permission.']);
            }

            $pincode = $request->pincode ?? NULL;
            $reporter = $request->reporter ?? NULL;
            $date = $request->date ?? NULL;
            $magazine = $request->magazine ?? NULL;

            $reporters = DB::table('reporter as r')->select(['u.id', 'u.firstname', 'u.lastname'])
                                ->leftjoin('users as u', 'u.id', 'r.user_id')
                                ->get();

            $collection = DB::table('users as u')
                            ->select('u.firstname', 'u.lastname', 'u.email',
                                        's.address', 's.phone', 's.pincode'
                                    )
                            ->join('subscribers as s', 'u.id', 's.user_id');

            if($pincode)
                $collection->where(['s.pincode' => $pincode]);
            elseif($reporter)
                $collection->where(['s.created_by' => $reporter]);
            elseif($date)
                $collection->whereDate('s.created_at', '=', $date);
            elseif($magazine)
                $collection->where('s.magazine', '=', $magazine);

            $data = $collection->orderBy('u.firstname')->get();

            return view('backend.subscriber.filter', ['data' => $data, 'reporters' => $reporters, 'pincode' => $pincode, 'reporter' => $reporter, 'date' => $date ,'magazine' => $magazine]);
        }


        public function excel(Request $request) {
            $pincode = $request->pincode ?? null;
            $reporter = $request->reporter ?? null;
            $date = $request->date ?? null;
            $magazine = $request->magazine ?? null;

            $filter = [
                        'pincode' => $pincode,
                        'reporter' => $reporter,
                        'date' => $date,
                        'magazine' => $magazine
                    ];

            return Excel::download(new SubscriberExport($filter), 'subscriber.xlsx');
        }
    }


