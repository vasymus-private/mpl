<?php

namespace Domain\Products\Jobs;

use Domain\Common\Models\CustomMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportClearJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected CustomMedia $media;

    /**
     * Create a new job instance.
     *
     * @param \Domain\Common\Models\CustomMedia $media
     *
     * @return void
     */
    public function __construct(CustomMedia $media)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->media->refresh()->forceDelete();
    }
}
