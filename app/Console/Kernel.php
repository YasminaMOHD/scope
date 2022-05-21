<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\ChangeStatus;
use App\Models\Description;
use App\Notifications\SendRemainder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->call(function(){
            $time =  Carbon::now()->format('Y-m-d H:i');
            $desc = Description::with('lead')->with('user')->where('reminder_at',$time)->get();
                foreach ($desc as $chunk){
                    $user = User::where('id',$chunk['user_id'])->first();
                    $user->notify(new SendRemainder($chunk));
            }
           })->everyMinute();

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
