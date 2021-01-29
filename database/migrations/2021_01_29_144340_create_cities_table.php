<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('district_id')->nullable()->unsigned();
            $table->bigInteger('taluka_id')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->string('pincode')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('taluka_id')->references('id')->on('talukas')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::table('cities')->insert(['name' => 'one', 'district_id' => 1, 'taluka_id' => 1, 'pincode' => '380001', 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('cities')->insert(['name' => 'two', 'district_id' => 1, 'taluka_id' => 2, 'pincode' => '380002', 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('cities')->insert(['name' => 'Three', 'district_id' => 2, 'taluka_id' => 3, 'pincode' => '360001', 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('cities')->insert(['name' => 'Four', 'district_id' => 2, 'taluka_id' => 3, 'pincode' => '360002', 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('cities')->insert(['name' => 'Five', 'district_id' => 2, 'taluka_id' => 4, 'pincode' => '360003', 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
