<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncomeTypeToDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('income_type_id')->nullable()->constrained('income_types');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('income_type_id')->nullable()->constrained('income_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['income_type_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['income_type_id']);
        });
    }
}
