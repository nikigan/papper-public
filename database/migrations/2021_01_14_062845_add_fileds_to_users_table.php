<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedFloat('social_security')->default(125.0);
            $table->tinyInteger('report_period')->default(1);
            $table->string('social_security_number')->nullable();
            $table->foreignId('default_income_type_id')->default(1)->constrained('income_types');
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
            $table->dropColumn('social_security');
            $table->dropColumn('report_period');
            $table->dropColumn('social_security_number');
            $table->dropForeign(['default_income_type_id']);
        });
    }
}
