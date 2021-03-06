<?php

namespace Pbmedia\ApiHealth\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pbmedia\ApiHealth\Checkers\Checker;
use Pbmedia\ApiHealth\Checkers\Executor;
use Pbmedia\ApiHealth\Storage\CheckerState;

class RetryChecker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $checker;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Checker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new CheckerState($this->checker))->addRetryTimestamp();

        (new Executor($this->checker))->handle();
    }
}
