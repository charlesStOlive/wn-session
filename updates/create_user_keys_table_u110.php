<?php namespace Waka\Session\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Schema;

class CreateUserKeysTableU110 extends Migration
{
    public function up()
    {
        Schema::table('waka_session_user_keys', function (Blueprint $table) {
            $table->string('dseable_id')->nullable();
            $table->string('dseable_type')->nullable();
            $table->boolean('user_delete_key')->default(false)->change();
        });
    }

    public function down()
    {
        Schema::table('waka_session_user_keys', function (Blueprint $table) {
            $table->dropColumn('dseable_id');
            $table->dropColumn('dseable_type');
        });
    }
}