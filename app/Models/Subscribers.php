<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Subscribers extends Model{
        use HasFactory;

        protected $table = 'subscribers';
        protected $pincode;
        protected $city_id;
        protected $reporter;
        protected $date;

        protected $fillable = ['receipt_no', 'description', 'address', 'phone', 'status', 'pincode', 'magazine'];

        public function getData($filter){
            $pincode = $filter['pincode'];
            $city_id = $filter['city_id'];
            $reporter = $filter['reporter'];
            $date = $filter['date'];
            $magazine = $filter['magazine'];

            $collection = DB::table('users as u')
                            ->select('u.firstname', 'u.lastname', 'u.email',
                                        's.address', 's.phone', 's.pincode',
                                        'd.name as district_name', 't.name as taluka_name', 'c.name as city_name'
                                    )
                            ->join('subscribers as s', 'u.id', 's.user_id')
                            ->leftjoin('districts as d', 'd.id', 's.district_id')
                            ->leftjoin('talukas as t', 't.id', 's.taluka_id')
                            ->leftjoin('cities as c', 'c.id', 's.city_id');

            if($pincode != '' && $pincode != null)
                $collection->where(['s.pincode' => $pincode]);
            elseif($city_id != '' && $city_id != null)
                $collection->where(['s.city_id' => $city_id]);
            elseif($reporter != '' && $reporter != null)
                $collection->where(['s.created_by' => $reporter]);
            elseif($date != '' && $date != null)
                $collection->whereDate('s.created_at', '=', $date);
            elseif($magazine != '' && $magazine != null)
                $collection->where('s.magazine', '=', $magazine);

            $newdata = $collection->where(['s.status' => 'active'])->orderBy('s.pincode')->get();
            return $newdata;
        }
    }
