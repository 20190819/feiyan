<?php

namespace App\Console\Commands;

use App\Console\Commands\Utils\MyHttp;
use App\Jobs\InsertHistoryData;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HistoryData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'h:data';

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
        $history = static::scrawlChinaDayList();
        foreach ($history as $value) {
            dispatch(new InsertHistoryData($value));
        }
        dd('ok  ' . now());
    }

    protected static function scrawlChinaDayList(): array
    {
        $url = 'https://api.inews.qq.com/newsqa/v1/query/inner/publish/modules/list';
        $response = MyHttp::Http()->get($url, [
            'modules' => 'chinaDayAddList,chinaDayList',
        ])->json();
        $list = Arr::get($response, 'data.chinaDayList');
        $add_list = Arr::get($response, 'data.chinaDayAddList');
        $history = [];
        foreach ($list as $item) {
            $history[$item['date']] = [
                'statistic_date' => static::formatDateString($item['date']),
                'confirm' => $item['confirm'],
                'suspect' => $item['suspect'],
                'heal' => $item['heal'],
                'dead' => $item['dead']
            ];
        }
        foreach ($add_list as $add_item) {
            $pre = $history[$add_item['date']];
            $history[$add_item['date']] = array_merge($pre, [
                'confirm_add' => $add_item['confirm'],
                'suspect_add' => $add_item['suspect'],
                'heal_add' => $add_item['heal'],
                'dead_add' => $add_item['dead']
            ]);
        }
        return $history;
    }

    public static function formatDateString(string $date_str): string
    {
        $date_str = '2020.' . $date_str;
        return str_replace('.', '-', $date_str);
    }
}
