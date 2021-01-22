<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Country;
    use App\Models\State;
    use App\Http\Requests\StateForm;
    use DataTables , DB;

    class StateController extends Controller{

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('state')
                            ->select('state.name' ,'state.id' , 'c.name AS country_name')
                            ->join('country AS c' ,'state.country_id' ,'c.id')
                            ->where('state.status' ,'active')
                            ->orderBy('state.id' ,'DESC')
                            ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            return '<div class="btn-group">
                                        <a href="'.route('admin.state.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;
                                        <a href="'.route('admin.state.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
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

            return view('backend.state.index');
        }

        public function create(Request $request){
            $country = Country::all();
            return view('backend.state.create')->with(['country' => $country]);
        }

        public function insert(StateForm $request){
            if($request->ajax()){ return true; }

            $data = new State();
            $data->name = ucfirst($request->name);
            $data->country_id = $request->country_id;
            $data->created_at = date('Y-m-d H:i:s');
            $data->created_by = auth()->user()->id;
            $data->updated_at = date('Y-m-d H:i:s');

            if($data->save()){
                return redirect()->route('admin.state')->with('success', 'State Inserted Successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }


        public function view(Request $request){
        	$id = base64_decode($request->id);
        	$state = DB::table('state')
                        ->select('state.id' ,'state.name' ,'c.name AS country_name')
                        ->join('country AS c' ,'state.country_id' ,'c.id')
                        ->where(['state.id' => $id])
                        ->first();
            return view('backend.state.view')->with(['state' => $state]);
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
        	$state = State::find($id);
            $country = Country::all();
            return view('backend.state.edit')->with(['state' => $state , 'country' => $country]);
        }

        public function update(StateForm $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;

            $crud = array(
                    'name' => ucfirst($request->name),
                    'country_id' => $request->country_id,
                    'updated_at' => date('Y-m-d H:i:s')
                );

            $update = DB::table('state')->where('id', $id)->limit(1)->update($crud);

            if($update){
                return redirect()->route('admin.state')->with('success', 'Country updated successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
            }
        }

        public function delete(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = $request->id;

                $delete = State::where('id', $id)->delete();

                if($delete){
                    return response()->json(['code' => 200]);
                }else{
                    return response()->json(['code' => 201]);
                }
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
