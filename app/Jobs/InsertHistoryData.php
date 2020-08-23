<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class InsertHistoryData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $one_history;

    /**
     * Create a new job instance.
     * @param $item
     * @return void
     */
    public function __construct($item)
    {
        $this->one_history = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \App\Models\HistoryStatic::query()->updateOrCreate([
            'statistic_date' => Arr::pull($this->one_history, 'statistic_date'),
        ], $this->one_history);
    }
}
