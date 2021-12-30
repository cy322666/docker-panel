<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckCondition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'проверяет наличие лидов по условиям';

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
        Log::info(__METHOD__);

        app()->call('App\Http\Controllers\CronController@check');

        return Command::SUCCESS;
    }
}
