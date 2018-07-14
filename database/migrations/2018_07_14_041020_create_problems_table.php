<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemsTable extends Migration
{
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->text('description');
            $table->smallInteger('memory_limit');
            $table->integer('time_limit');
            $table->unsignedInteger('owner_id')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');

            $table->unique([
                'slug'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('problems');
    }
}
