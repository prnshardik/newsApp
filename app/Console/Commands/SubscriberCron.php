<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SubscriberCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:subscriber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscriber subscription inactive cronjob';

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
        DB::table('subscribers')->whereDate('end_date', '<=', date('Y-m-d'))->update(['status' => 'inactive']);
    }
}
