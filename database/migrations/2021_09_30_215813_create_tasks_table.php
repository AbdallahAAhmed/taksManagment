<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name')->unique();
            $table->string('end_date');
            $table->string('start_date');
            $table->text('task_description',255)->nullable();
            $table->enum('status',['inProgress','completed'])->default('inProgress');

            $table->unsignedBigInteger('user_id')->comment('assign_to');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->tinyInteger('isDelete')->default(0);
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
        Schema::dropIfExists('tasks');
    }
}
