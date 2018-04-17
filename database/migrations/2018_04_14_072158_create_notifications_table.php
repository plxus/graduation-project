<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('send_id');  // 发件人 ID
            $table->integer('receive_id');  // 收件人 ID
            $table->string('subject')->nullable();  // 主题
            $table->string('content');  // 内容
            $table->boolean('send_is_delete')->default(false);  // 判断发件人是否已删除某条私信
            $table->boolean('receive_is_delete')->default(false);  // 判断收件人是否已删除某条私信
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
        Schema::dropIfExists('notifications');
    }
}
