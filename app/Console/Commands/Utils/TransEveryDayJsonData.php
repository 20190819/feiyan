<?php


namespace App\Console\Commands\Utils;


use Illuminate\Support\Str;

class TransEveryDayJsonData
{
    public static function jsonData(string $response): array
    {
        $json_str = Str::substr($response, 38, -1);
        $arr = json_decode($json_str, true);
        return json_decode($arr['data'], true);

    }
}
