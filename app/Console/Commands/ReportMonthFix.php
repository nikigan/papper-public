<?php

namespace Vanguard\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Vanguard\Document;

class ReportMonthFix extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report_month:fix';

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
        $documents = Document::withTrashed()->get();

        foreach ( $documents as $document ) {
            $date = ( new Carbon( $document->document_date ) )->startOfMonth();

            $this->info( "Changing document $document->id report moth to $date" );
            $document->report_month = $date;
            $document->save();
        }

        return 0;
    }
}
