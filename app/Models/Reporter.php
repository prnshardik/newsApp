<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Reporter extends Model{
        use HasFactory;

    	public $table = 'reporter';

        protected $fillable = ['unique_id', 'address', 'phone_no', 'receipt_book_start_no', 'receipt_book_end_no', 'district_id', 'taluka_id', 'city_id', 'profile', 'status'];
    }
