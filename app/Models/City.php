<?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Notifications\Notifiable;
    use Spatie\Permission\Traits\HasRoles;

    class City extends Model
    {
    	public $table = 'city';
        protected $fillable = ['name', 'country_id', 'state_id', 'status'];
    }
