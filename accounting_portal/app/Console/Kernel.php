<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Accounting_invoice;
use App\Console\Commands\UpdateQuotationStatus;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateQuotationStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            Accounting_invoice::query()
                ->where('invoice_sr_no', null) // Use comma instead of == for comparison
                ->where('submit_date', '<', today()->subDays(59))
                ->update(['entry_status' => 'E', 'remarks' => 'AND']);
        })->daily();

     /* $schedule->command('quotation:update-status')
        ->everyMinute(); */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
