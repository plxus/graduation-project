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
      $table->string('title')->index();
      $table->string('description')->nullable()->index();
      $table->longText('content');
      $table->integer('category_id')->index();  // 知识清单类别 ID
      $table->string('copyright')->default('limit');  // allow 允许转载，limit 需授权，forbid 禁止转载。
      $table->boolean('is_private')->default(false)->index();
      $table->integer('user_id')->index();
      $table->integer('star_num')->default(0)->index();  // 收藏数
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
