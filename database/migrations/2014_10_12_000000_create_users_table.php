<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        // 调用 create 方法创建数据表，有两个参数，第一个是数据表名，第二个是 $table 的闭包。
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('bio')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 调用 table 方法更新现有数据表。table 方法会接受两个参数：一个是数据表的名称，另一个则是接收可以用来向表中添加字段的 Blueprint 实例的闭包。
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
