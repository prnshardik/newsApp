<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Country;
    use App\Models\State;
    use App\Models\City;
    use App\Http\Requests\CityForm;
    use DataTables , DB;

    class CityController extends Controller{

        public function index(Request $request){
        	if($request->ajax()){
                $data = DB::table('city')
                            ->select('city.name' ,'city.id' , 'c.name AS country_name' ,'state.name AS state_name')
                            ->join('country AS c' ,'city.country_id' ,'c.id')
                            ->join('state' ,'city.state_id' ,'state.id')
                            ->where('city.status' ,'active')
                            ->orderBy('city.id' ,'DESC')
                            ->get();

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($data){
                            return '<div class="btn-group">
                                        <a href="'.route('admin.city.view', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> &nbsp;
                                        <a href="'.route('admin.city.edit', ['id' => base64_encode($data->id)]).'" class="btn btn-default btn-xs">
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

            return view('backend.city.index');
        }

        public function create(Request $request){
            $country = Country::all();
            $state = State::all();
            return view('backend.city.create')->with(['country' => $country ,'state' => $state]);
        }

        public function insert(CityForm $request){
            if($request->ajax()){ return true; }

            $data = new City();
            $data->name = ucfirst($request->name);
            $data->country_id = $request->country_id;
            $data->state_id = $request->state_id;
            $data->created_at = date('Y-m-d H:i:s');
            $data->created_by = auth()->user()->id;
            $data->updated_at = date('Y-m-d H:i:s');

            if($data->save()){
                return redirect()->route('admin.city')->with('success', 'City Inserted Successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to insert record.')->withInput();
            }
        }


        public function view(Request $request){
        	$id = base64_decode($request->id);
        	$city = DB::table('city')
                            ->select('city.name' ,'city.id' , 'c.name AS country_name' ,'state.name AS state_name')
                            ->join('country AS c' ,'city.country_id' ,'c.id')
                            ->join('state' ,'city.state_id' ,'state.id')
                            ->where('city.id' ,$id)
                            ->first();

            return view('backend.city.view')->with(['city' => $city]);
        }

        public function edit(Request $request){
        	$id = base64_decode($request->id);
        	$city = DB::table('city')
                    ->select('city.*' ,'state.id AS state_id' ,'state.name AS state_name' ,'.country.name AS country_name' ,'country.id AS country_id')
                    ->join('country' ,'city.country_id' ,'country.id')
                    ->join('state' ,'city.state_id' ,'state.id')
                    ->where(['city.id' => $id])
                    ->first();
            $country = Country::all();
            return view('backend.city.edit')->with(['city' => $city ,'country' => $country]);
        }

        public function update(CityForm $request){
        	if($request->ajax()){ return true ;}

            $id = $request->id;

            $crud = array(
                    'name' => ucfirst($request->name),
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'updated_at' => date('Y-m-d H:i:s')
                );

            $update = DB::table('city')->where('id', $id)->limit(1)->update($crud);

            if($update){
                return redirect()->route('admin.city')->with('success', 'Country updated successfully.');
            }else{
                return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
            }
        }

        public function delete(Request $request){
            if(!$request->ajax()){ exit('No direct script access allowed'); }

            if(!empty($request->all())){
                $id = $request->id;

                $delete = City::where('id', $id)->delete();

                if($delete){
                    return response()->json(['code' => 200]);
                }else{
                    return response()->json(['code' => 201]);
                }
            }else{
                return response()->json(['code' => 201]);
            }
        }

        public function get_state(Request $request){
            $country_id = $request->country_id;

            $data = State::select('id', 'name')->where(['country_id' => $country_id])->get();

            if(isset($data) && $data->isNotEmpty()){
                $html = '<option value="">select state</option>';
                foreach($data as $row){
                    $html .= "<option value='".$row->id."'>".$row->name."</option>";
                }
                return response()->json(['code' => 200, 'data' => $html]);
            }else{
                return response()->json(['code' => 201]);
            }
        }
    }
