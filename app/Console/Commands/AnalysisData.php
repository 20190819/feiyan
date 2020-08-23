<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class AnalysisData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ana:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $json_str=file_get_contents(database_path('seeds/data/fy_data.json'));
        $arr=json_decode($json_str,true);
//        dd(array_keys($arr));
        dd(count($arr['areaTree'][0]['children']));
    }
}
