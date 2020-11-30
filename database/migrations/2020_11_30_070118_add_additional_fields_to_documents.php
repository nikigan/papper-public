<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('document_number')->nullable();
            $table->tinyInteger('document_type')->nullable();
            $table->float('sum')->nullable();
            $table->float('sum_without_vat')->nullable();
            $table->float('vat')->nullable();
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
            $table->dropColumn('document_number');
            $table->dropColumn('document_type');
            $table->dropColumn('sum');
            $table->dropColumn('sum_without_vat');
            $table->dropColumn('vat');
        });
    }
}
