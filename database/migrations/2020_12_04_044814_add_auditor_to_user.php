<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditorToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('auditor_id')->nullable();
            $table->unsignedInteger('accountant_id')->nullable();
            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('accountant_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->dropForeign('users_auditor_id_foreign');
//            $table->dropForeign('users_accountant_id_foreign');
//            $table->dropColumn('auditor_id');
//            $table->dropColumn('accountant_id');
        });
    }
}
