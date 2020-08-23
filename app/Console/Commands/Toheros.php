<?php

namespace App\Console\Commands;

use App\Console\Commands\Utils\MyHttp;
use App\Models\ToHero;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Toheros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'to:hero';

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
        $url = 'https://eyesight.news.qq.com/sars/toheros';
        $response = MyHttp::Http()->get($url)->json();
        if (Arr::has($response, 'code')) {
            if ($response['code'] == 0) {
                $all_heros = Arr::get($response, 'data.allHeros');
                $bar = $this->output->createProgressBar(count($all_heros));
                $bar->start();
                foreach ($all_heros as $hero) {
                    Arr::pull($hero, 'cid');
                    ToHero::query()->create($hero);
                    $bar->advance();
                }
            }
        } else {
            $this->error('数据异常');
        }
        dd();
    }
}
