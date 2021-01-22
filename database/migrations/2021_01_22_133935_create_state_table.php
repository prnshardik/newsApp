<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country_id');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });

        DB::table('state')->insert(
            array(
                'name' => 'Gujarat',
                'country_id' => 1,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('state')->insert(
            array(
                'name' => 'Maharastra',
                'country_id' => 1,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('state')->insert(
            array(
                'name' => 'Queensland',
                'country_id' => 2,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('state')->insert(
            array(
                'name' => 'Victoria',
                'country_id' => 2,
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
        Schema::dropIfExists('state');
    }
}
