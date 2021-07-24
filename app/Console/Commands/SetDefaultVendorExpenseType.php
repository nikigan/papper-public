<?php

namespace Vanguard\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vanguard\Document;
use Vanguard\Vendor;

class SetDefaultVendorExpenseType extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $vendors = Document::groupBy( [
            'vendor_id',
            'expense_type_id'
        ] )->select( DB::raw( 'vendor_id, expense_type_id, COUNT(*) as count' ) )->where( 'vendor_id', "!=", "null" )->where( 'expense_type_id', "!=", "null" )->orderBy( 'count', 'DESC' )->get()->groupBy( [ 'vendor_id' ] )->map( fn( $group ) => $group->take( 1 ) );
        foreach ( $vendors as $vendorId ) {
            $vendId = $vendorId[0]->vendor_id;
            $expId  = $vendorId[0]->expense_type_id;
            $this->info( "Set expense type $expId for vendor $vendId" );
            $vendor = Vendor::find( $vendorId[0]->vendor_id );
            $vendor->default_expense_type_id = $vendorId[0]->expense_type_id;
            $vendor->save();
        }

        return 0;
    }
}
