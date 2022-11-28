<?php namespace Waka\Session\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Schema;

class ChangeWakaSessionsTableU111 extends Migration
{
    public function up()
    {
        Schema::table('waka_session_waka_sessions', function (Blueprint $table) {
           $table->string('ds_id_test',50)->change();
        });
    }

    public function down()
    {
    }
}