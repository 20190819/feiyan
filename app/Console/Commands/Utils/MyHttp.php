<?php


namespace App\Console\Commands\Utils;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class MyHttp
{
    public static function Http(): PendingRequest
    {
        return Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36'
        ]);
    }
}
