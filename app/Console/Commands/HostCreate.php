<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Host;

class HostCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'host:create {hostname} {flags?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new host with a given hostname which will scan for specific record types based on the flags set (A, AAAA, MX, CNAME).';

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
        $flagsArgs = $this->argument('flags');
        $flagInt = 0;

        $flagMapping = [
            'A' => DNS_A,
            'AAAA' => DNS_AAAA,
            'MX' => DNS_MX,
            'CNAME' => DNS_CNAME,
        ];

        if ($flagsArgs) {
            foreach ($flagsArgs as $flag) {
                if (array_key_exists($flag, $flagMapping)) {
                    $flagInt = $flagInt | $flagMapping[$flag];
                }
            }
        } else {
            $flagInt = array_sum($flagMapping);
        }

        $hostData = [
            'hostname' => $this->argument('hostname'),
            'flags' => $flagInt,
        ];

        Host::create($hostData);
    }
}
