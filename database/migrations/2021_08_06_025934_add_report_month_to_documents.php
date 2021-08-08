<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportMonthToDocuments extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'documents', function ( Blueprint $table ) {
            $table->date( 'report_month' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'documents', function ( Blueprint $table ) {
            $table->dropColumn( 'report_month' );
        } );
    }
}
