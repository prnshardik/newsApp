<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Talukas extends Model{
        use HasFactory;

        protected $table = 'talukas';

        protected $fillable = ['name', 'district_id', 'status'];
    }
