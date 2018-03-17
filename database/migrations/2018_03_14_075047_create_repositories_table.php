<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->longText('content');
            $table->string('category_level_1');  // 一级类别
            $table->string('category_level_2')->nullable();  // 二级类别
            $table->string('copyright')->default('limit');  // allow 允许转载，limit 需授权，forbid 禁止转载。
            $table->boolean('is_private')->default(false);
            $table->integer('user_id')->index();
            $table->timestamps();
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
