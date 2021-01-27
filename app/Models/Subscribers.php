<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use DB;

    class Subscribers extends Model{
        use HasFactory;

        protected $table = 'subscribers';
        protected $pincode;
        protected $city;
        protected $reporter;
        protected $date;

        protected $fillable = ['receipt_no', 'description', 'address', 'phone', 'status', 'pincode', 'magazine', 'country', 'state', 'city'];

        public function getData($filter){
            $pincode = $filter['pincode'];
            $city = $filter['city'];
            $reporter = $filter['reporter'];
            $date = $filter['date'];
            $magazine = $filter['magazine'];

            $collection = DB::table('users as u')
                            ->select('u.firstname', 'u.lastname', 'u.email',
                                        's.address', 's.phone', 's.pincode',
                                        'c.name as country_name', 'st.name as state_name', 'ct.name as city_name',
                                    )
                            ->join('subscribers as s', 'u.id', 's.user_id')
                            ->join('country as c', 'c.id', 's.country')
                            ->join('state as st', 'st.id', 's.state')
                            ->join('city as ct', 'ct.id', 's.city');

            if($pincode != '' && $pincode != null)
                $collection->where(['s.pincode' => $pincode]);
            elseif($city != '' && $city != null)
                $collection->where(['s.city' => $city]);
            elseif($reporter != '' && $reporter != null)
                $collection->where(['s.created_by' => $reporter]);
            elseif($date != '' && $date != null)
                $collection->whereDate('s.created_at', '=', $date);
            elseif($magazine != '' && $magazine != null)
                $collection->where('s.magazine', '=', $magazine);

            $newdata = $collection->where('u.status','active')->orderBy('u.firstname')->get();
            return $newdata;
        }
    }
