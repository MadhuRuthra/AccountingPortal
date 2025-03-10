<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Accounting_invoice;
use Illuminate\Support\Facades\Log;

class UpdateQuotationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotation:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update quotation status for expired quotations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(44)->format('Y-m-d H:i:s');

        $submit_date = date("Y-m-d H:i:s");
    
        // Find quotations with dates exactly 45 days ago and update their status
        Accounting_invoice::where('submit_date', '=', $thirtyDaysAgo)
        ->whereNotNull('invoice_sr_no')
        ->update(['entry_status' => 'E', 'remarks' => 'AND']);
    
         $this->info('Accounting invoice status updated successfully.');
    }
}
