<?php

namespace App\Console;

use Redis;
use App\Member;
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
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $member = new Member;

            $member->date = new \DateTime('yesterday midnight');
            $member->Total = Redis::sCard('Total');
            $member->HotPlace = Redis::sCard('HotPlace');

            foreach (Redis::keys('Korea:*') as $key) {
                $location = str_replace('Korea:', '', $key);
                $member->$location = Redis::sCard($key);
            }

            $world = array();
            foreach (Redis::keys('World:*') as $key) {
                $location = str_replace('World:', '', $key);
                $world[] = [$location => Redis::sCard($key)];
            }
            $member->World = json_encode($world);
            $member->Info = json_encode(Redis::hGetAll('MemberInfo'));

            $member->save();
        })->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
