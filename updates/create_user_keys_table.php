<?php namespace Waka\Session\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Schema;

class CreateUserKeysTable extends Migration
{
    public function up()
    {
        Schema::create('waka_session_user_keys', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->date('key_end_at')->nullable();
            $table->boolean('user_delete_key')->nullable()->default(false);
            $table->integer('waka_session_id')->unsigned()->nullable();
            $table->string('owner')->nullable();
            $table->string('secret')->nullable();
            $table->text('data')->nullable();
            $table->string('ds_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_session_user_keys');
    }
}