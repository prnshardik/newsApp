<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->id();
            $table->string('country_id');
            $table->string('state_id');
            $table->string('name');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });

        DB::table('city')->insert(
            array(
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Rajkot',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('city')->insert(
            array(
                'country_id' => 1,
                'state_id' => 1,
                'name' => 'Ahmdabad',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('city')->insert(
            array(
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Mumbai',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('city')->insert(
            array(
                'country_id' => 1,
                'state_id' => 2,
                'name' => 'Pune',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );


        DB::table('city')->insert(
            array(
                'country_id' => 2,
                'state_id' => 1,
                'name' => 'Gold Coast',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('city')->insert(
            array(
                'country_id' => 2,
                'state_id' => 1,
                'name' => 'Townsville',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('city')->insert(
            array(
                'country_id' => 2,
                'state_id' => 2,
                'name' => 'Melbourne',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('city')->insert(
            array(
                'country_id' => 2,
                'state_id' => 2,
                'name' => 'Portland',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city');
    }
}
