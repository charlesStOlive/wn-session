<?php namespace Waka\Session\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Schema;

class CreateUserKeysTableU112 extends Migration
{
    public function up()
    {
        Schema::table('waka_session_user_keys', function (Blueprint $table) {
            $table->mediumText('data')->change();
        });
    }

    public function down()
    {
    }
}