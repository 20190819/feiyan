<?php

namespace App\Console\Commands;

use App\Console\Commands\Utils\MyHttp;
use App\Console\Commands\Utils\TransEveryDayJsonData;
use App\Models\EveryDayRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EveryDayData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'e:data';

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
        echo 'START ' . now() . PHP_EOL;
        $url = 'https://view.inews.qq.com/g2/getOnsInfo';
        $response = MyHttp::Http()->get($url, [
            'name' => 'disease_h5',
            'callback' => 'jQuery34100390329948139152_' . now()->timestamp,
            '_' => now()->timestamp
        ])->body();
        $arr = TransEveryDayJsonData::jsonData($response);

        $last_update_time = Arr::get($arr, 'lastUpdateTime');
        $area_tree = Arr::get($arr, 'areaTree');
        // 入库
        static::childrenData($last_update_time, $area_tree);
        dd('OK ' . now());
    }

    protected static function childrenData(string $last_update_time, array $area_tree, $province = '中国')
    {
        foreach ($area_tree as $item) {
            $children = Arr::pull($item, 'children', null);
            EveryDayRecord::query()->updateOrCreate([
                'province' => $province,
                'city' => Arr::get($item, 'name')
            ], [
                'last_update_time' => $last_update_time,
                'confirm_today' => Arr::get($item, 'today.confirm'),
                'confirm_now' => Arr::get($item, 'total.nowConfirm'),
                'confirm_total' => Arr::get($item, 'total.confirm'),
                'suspect_total' => Arr::get($item, 'total.suspect'),
                'dead_total' => Arr::get($item, 'total.dead'),
                'heal_total' => Arr::get($item, 'total.heal')
            ]);
            if ($children) {
                static::childrenData($last_update_time, $children, Arr::get($item, 'name'));
            }
        }
    }
}
