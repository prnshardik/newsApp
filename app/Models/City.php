<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class City extends Model
    {
        use HasFactory;
    	public $table = 'city';
        protected $fillable = ['name', 'country_id', 'state_id', 'status'];
    }
