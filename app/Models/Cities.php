<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Cities extends Model{
        use HasFactory;

        protected $table = 'cities';

        protected $fillable = ['name', 'pincode', 'district_id', 'taluka_id', 'status'];
    }
