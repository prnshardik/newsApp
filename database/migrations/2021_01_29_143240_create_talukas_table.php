<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalukasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talukas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('district_id')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::table('talukas')->insert(['name' => 'Kalol', 'district_id' => 1, 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('talukas')->insert(['name' => 'Kadi', 'district_id' => 1, 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('talukas')->insert(['name' => 'Rajkot West', 'district_id' => 2, 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('talukas')->insert(['name' => 'Rajkot East', 'district_id' => 2, 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('talukas')->insert(['name' => 'Rajkot West', 'district_id' => 2, 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talukas');
    }
}
