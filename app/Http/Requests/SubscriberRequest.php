<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class SubscriberRequest extends FormRequest{

        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'receipt_no' => 'required',
                    'address' => 'required',
                    'phone' => 'required|digits:10',
                    'pincode' => 'required',
                    'magazine' => 'required',
                    // 'district_id' => 'required',
                    // 'taluka_id' => 'required',
                    // 'city_id' => 'required'
                ];
            }else{
                return [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'receipt_no' => 'required',
                    'address' => 'required',
                    'phone' => 'required|digits:10',
                    'pincode' => 'required',
                    'magazine' => 'required',
                    // 'district_id' => 'required',
                    // 'taluka_id' => 'required',
                    // 'city_id' => 'required'
                ];
            }
        }

        public function messages(){
            return [
                'receipt_no.required' => 'Please enter receipt no',
                'address.required' => 'Please enter address',
                'phone.required' => 'Please enter phone',
                'pincode.required' => 'Please enter pincode',
                'magazine.required' => 'Please select magazine',
                // 'district_id.required' => 'Please enter district',
                // 'taluka_id.required' => 'Please enter taluka',
                // 'city_id.required' => 'Please select city',
            ];
        }
    }
