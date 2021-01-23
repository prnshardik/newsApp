<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporter', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unique_id');
            $table->text('address');
            $table->string('phone_no');
            $table->string('email');
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->string('receipt_book_start_no');
            $table->string('receipt_book_end_no');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reporter');
    }
}
