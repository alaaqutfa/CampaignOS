<?php
namespace App\Jobs;

use App\Models\DesignJob;
use App\Services\DesignJobService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDesignToPython implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public DesignJob $designJob;

    public function __construct(DesignJob $designJob)
    {
        $this->designJob = $designJob;
    }

    public function handle(DesignJobService $service): void
    {
        $service->sendToPython($this->designJob);
    }
}
