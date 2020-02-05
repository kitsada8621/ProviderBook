<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->string('p_id')->primary();
            $table->string('p_name');
            $table->string('category');
            $table->string('t_id');
            $table->string('std_id');
            $table->dateTime('createdate');
            $table->text('description');
            $table->foreign('std_id')->references('std_id')->on('student')->onDelete('cascade');
            $table->foreign('t_id')->references('t_id')->on('teacher')->onDelete('cascade');
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
        Schema::dropIfExists('project');
    }
}
