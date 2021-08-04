<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanChangeIvoiceNumberToUsers extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->boolean( 'can_change_invoice_number' )->default( false );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropColumn( 'can_change_invoice_number' );
        } );
    }
}
