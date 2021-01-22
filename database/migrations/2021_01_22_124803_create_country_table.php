<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country_code');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });

         DB::table('country')->insert(
            array(
                'name' => 'India',
                'country_code' => '+91',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
            )
        );

        DB::table('country')->insert(
            array(
                'name' => 'Australia',
                'country_code' => '+63',
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
        Schema::dropIfExists('country');
    }
}
