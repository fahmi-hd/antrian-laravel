<?php

namespace App\Jobs;

use App\Events\CallQueueEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCallQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $antrian;
    public $audioFiles;
    public $counter;

    public function __construct($queue,$audioFiles,$counter)
    {
        $this->antrian=$queue;
        $this->audioFiles=$audioFiles;
        $this->counter=$counter;
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new CallQueueEvent($this->antrian,$this->audioFiles,$this->counter));
    }
}
