<?php

namespace Domain\Products\Jobs;

use Domain\Products\Actions\ExportImport\ExportProductsAction;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DateInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class ExportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const ARCHIVE_FILE_NAME_PREFIX = 'product-export';

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * @var int[]
     */
    protected array $productsIds;

    /**
     * Create a new job instance.
     *
     * @param int[]
     *
     * @return void
     */
    public function __construct(array $productsIds)
    {
        $this->productsIds = $productsIds;
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
        Log::info(sprintf('max execution time: %s', ini_get('max_execution_time')));

        Log::info(sprintf('%s---%s', static::class, exec('whoami')));

        $tempFilePath = $exportProductsAction->execute($this->productsIds);

        Log::info(sprintf('%s---%s', static::class, exec('whoami')));

        $tempFileFileSize = filesize($tempFilePath) * 2; // + buffer just for case
        config()->set('media-library.max_file_size', $tempFileFileSize);

        $name = sprintf('%s--%s.zip', static::ARCHIVE_FILE_NAME_PREFIX, Carbon::now()->format('Y-m-d--H-i-s')); // todo write to spatie about error with pathinfo if there is : in the name
        // todo @see \Spatie\MediaLibrary\MediaCollections\FileAdder::toMediaCollection()
        // todo @see \Spatie\MediaLibrary\Support\FileNamer\FileNamer::originalFileName()

        $centralAdmin = Admin::getCentralAdmin();
        /** @var \Domain\Common\Models\CustomMedia $media */
        $media = $centralAdmin
            ->addMedia($tempFilePath)
            ->setFileName($name)
            ->toMediaCollection(Admin::MC_EXPORT_PRODUCTS);

        Log::info(sprintf('%s---%s', static::class, exec('whoami')));

        $interval = new DateInterval('P1D');
        $deleteTime = Carbon::now()->add($interval);
        $media->setCustomProperty('deleteTime', $deleteTime);
        $media->save();
        ExportClearJob::dispatch($media)->delay($interval);
    }
}
