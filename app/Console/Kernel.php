<?php

/**
* Description:
* Kernel (console) class
* 
* List of methods:
* - schedule(Schedule $schedule) | define the application's command schedule
* - commands() | register the commands for the application
*/

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
    * Description:
    * define the application's command schedule
    *
    * List of parameters:
    * - $schedule : Illuminate\Console\Scheduling\Schedule
    *
    * Return:
    * - none
    */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }


    /**
    * Description:
    * register the commands for the application
    *
    * List of parameters:
    * - none
    *
    * Return:
    * - none
    */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
