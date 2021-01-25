<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Subscription extends Model{
        use HasFactory;

        protected $table = 'subscription';

        protected $fillable = ['user_id', 'start_date', 'end_date', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    }
