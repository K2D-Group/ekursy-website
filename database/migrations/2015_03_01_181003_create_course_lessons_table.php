<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_lessons', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('slug');
            $table->string('name')->nullable();
            $table->text('content');
            $table->text('authors');
            $table->text('reviewers');
            $table->text('sources');
            $table->text('updates');
            $table->date('last_update')->nullable();
            $table->boolean('need_login')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_lessons');
	}

}
