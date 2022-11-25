<?php namespace Waka\Session\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Schema;

class CreateWakaSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_session_waka_sessions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('key_duration')->nullable();
            $table->boolean('has_ds')->nullable();
            $table->string('data_source')->nullable();
            $table->integer('ds_id_test')->nullable();
            $table->boolean('embed_all_ds')->nullable();
            $table->text('mapping')->nullable();
            $table->text('default')->nullable();
            $table->string('page_scope')->nullable();
            $table->string('url')->nullable();
            $table->string('sessioneable_id')->nullable();
            $table->string('sessioneable_type')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_session_waka_sessions');
    }
}