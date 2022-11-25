<?php namespace Waka\Session\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Schema;

class ChangeUserKeysTableU110 extends Migration
{
    public function up()
    {
        $table = 'waka_session_user_keys';
        \DB::table($table)->where('user_delete_key', null)->update(['user_delete_key' => false]);
    }

    public function down()
    {
        
    }
}