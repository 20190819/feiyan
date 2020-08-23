<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GetDataFromQQNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从腾讯新闻获取（疫情）数据';

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
        $url = 'https://view.inews.qq.com/g2/getOnsInfo';
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36'
        ])->get($url, [
            'name' => 'disease_h5',
            'callback' => 'jQuery34100390329948139152_' . now()->timestamp,
            '_' => now()->timestamp
        ])->body();
        $json_str = Str::substr($response, 38, -1);
        file_put_contents(database_path('seeds/data/fy_response.txt'), $json_str);
        $arr = json_decode($json_str, true);
        $data = json_decode($arr['data'], true);
        $trans_json = json_encode($data, 256);
        file_put_contents(database_path('seeds/data/fy_data.json'), $trans_json);
        $this->info('ok');
    }
}
