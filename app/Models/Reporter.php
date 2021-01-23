<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Reporter extends Model{
        use HasFactory;

    	public $table = 'reporter';

        protected $fillable = ['name', 'unique_id' , 'address' , 'phone_no' , 'email' , 'country_id' , 'state_id' , 'city_id' , 'receipt_book_start_no' , 'receipt_book_end_no' , 'status'];
    }
