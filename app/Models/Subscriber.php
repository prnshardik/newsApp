<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Subscriber extends Model{
        use HasFactory;

        protected $table = 'subscribers';

        protected $fillable = ['receipt_no', 'description', 'address', 'phone', 'status', 'pincode', 'country', 'state', 'city'];
    }
