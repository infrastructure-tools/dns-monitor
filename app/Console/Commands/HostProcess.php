<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Host;

class HostProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'host:process {hostnames?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all hosts and record their DNS data.';

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
        $hostnames = $this->argument('hostnames');
        $hosts = [];
        if ($hostnames) {
            $hosts = Host::hostnameIn($hostnames)->get();
        } else {
            $hosts = Host::all();
        }

        foreach ($hosts as $host) {
            $host->process();
        }
    }
}
