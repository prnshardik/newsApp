<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateSubscribersTable extends Migration{
        public function up(){
            Schema::create('subscribers', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id')->nullable()->unsigned();
                $table->string('receipt_no')->nullable();
                $table->string('description')->nullable();
                $table->text('address')->nullable();
                $table->string('phone')->nullable();
                $table->string('pincode')->nullable();
                $table->integer('country')->nullable();
                $table->integer('state')->nullable();
                $table->integer('city')->nullable();
                $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
                $table->timestamps();
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            });
        }

        public function down(){
            Schema::dropIfExists('subscribers');
        }
    }
