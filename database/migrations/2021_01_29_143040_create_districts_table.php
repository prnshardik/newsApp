<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });

        DB::table('districts')->insert(['name' => 'Ahmedabad', 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
        DB::table('districts')->insert(['name' => 'Rajkot', 'status' => 'active', 'created_at' => date('Y-m-d H:s:i'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:s:i'), 'updated_by' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
