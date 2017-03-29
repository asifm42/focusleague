<?php

namespace App\Console\Commands;

use App\Mail\Alert\DelinquentsList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDelinquentsListEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendDelinquentsList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a list of the delinquents to Asif.';

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
     * @return mixed
     */
    public function handle()
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')->queue(new DelinquentsList());

        $this->info('Delinquents list email queued');
    }
}
