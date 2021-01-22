<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Country;
    use App\Http\Requests\CountryForm;
    use DataTables ,DB;

    class CountryController extends Controller{

        public function index(Request $request){
        	if($request->ajax()){
                $data = Country::select('id', 'name', 'country_code')->orderBy('id' ,'DESC')->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            return '<div class="btn-group">
                                        <a href="'.route('admin.country.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;
                                        <a href="'.route('admin.country.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
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

            return view('backend.country.index');
        }

        public function create(Request $request){
            return view('backend.country.create');
        }

        public function insert(CountryForm $request){
            if($request->ajax()){ return true; }

            $data = new Country();
            $data->name = ucfirst($request->name);
            $data->country_code = $request->country_code;
            $data->created_at = date('Y-m-d H:i:s');
            $data->created_by = auth()->user()->id;
            $data->updated_at = date('Y-m-d H:i:s');

            if($data->save()){
                return redirect()->route('admin.country')->with('success', 'Country Inserted Successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }


        public function view(Request $request){
        	$id = base64_decode($request->id);
        	$country = Country::find($id);
            return view('backend.country.view')->with(['country' => $country]);
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
        	$country = Country::find($id);
            return view('backend.country.edit')->with(['country' => $country]);
        }

        public function update(CountryForm $request){
        	if($request->ajax()){ return true ;}
            $id = $request->id;

            $crud = array(
                    'name' => ucfirst($request->name),
                    'country_code' => $request->country_code,
                    'updated_at' => date('Y-m-d H:i:s')
                );

            $update = DB::table('country')->where('id', $id)->limit(1)->update($crud);

            if($update){
                return redirect()->route('admin.country')->with('success', 'Country updated successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
            }
        }

        public function delete(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = $request->id;

                $delete = Country::where('id', $id)->delete();

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
