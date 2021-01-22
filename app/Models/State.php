<?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Notifications\Notifiable;
    use Spatie\Permission\Traits\HasRoles;

    class State extends Model
    {
    	public $table = 'state';
        protected $fillable = ['name', 'country_id', 'status'];
    }
