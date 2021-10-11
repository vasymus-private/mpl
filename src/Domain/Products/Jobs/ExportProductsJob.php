<?php

namespace Domain\Products\Jobs;

use Domain\Products\Actions\ExportImport\ExportProductsAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DateInterval;
use Illuminate\Support\Carbon;

class ExportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $products;

    /**
     * Create a new job instance.
     *
     * @param \Domain\Products\Models\Product\Product[]
     *
     * @return void
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @param \Domain\Products\Actions\ExportImport\ExportProductsAction $exportProductsAction
     *
     * @return void
     */
    public function handle(ExportProductsAction $exportProductsAction)
    {
        $media = $exportProductsAction->execute($this->products);
        $interval = new DateInterval('P1D');
        $deleteTime = Carbon::now()->add($interval);
        $media->setCustomProperty('deleteTime', $deleteTime);
        $media->save();
        ExportClearJob::dispatch($media)->delay($interval);
    }
}
