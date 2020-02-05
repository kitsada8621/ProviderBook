<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow', function (Blueprint $table) {
            $table->bigIncrements('br_id');
            $table->string('b_id');
            $table->string('status')->nullable();
            $table->string('std_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->dateTime('br_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('returning')->nullable();
            $table->foreign('b_id')->references('b_id')->on('book')->onDelete('cascade');
            $table->foreign('std_id')->references('std_id')->on('student')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrow');
    }
}
