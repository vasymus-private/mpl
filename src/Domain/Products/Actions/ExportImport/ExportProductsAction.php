<?php

namespace Domain\Products\Actions\ExportImport;

use Domain\Common\Models\CustomMedia;
use Domain\Products\Collections\ProductCollection;
use Domain\Products\DTOs\ExportProductDTO;
use Domain\Products\DTOs\ExportVariationDTO;
use Domain\Products\Exceptions\ExportProductException;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Carbon;
use ZipArchive;

class ExportProductsAction
{
    private const PRODUCT_DATA_FILE_NAME = 'product.json';

    private const VARIATION_DATA_FILE_NAME = 'variation.json';

    private ZipArchive $zip;

    private string $basePath;

    private string $name;

    public function __construct()
    {
        $this->zip = new ZipArchive();
        $this->basePath = storage_path('app/export/products');
        $this->name = sprintf('%s.zip', Carbon::now()->format('Y-m-d--H:i:s'));
    }

    /**
     * @param \Domain\Products\Models\Product\Product[] $products
     *
     * @return string Full file path to .zip archive
     *
     * @throws \Domain\Products\Exceptions\ExportProductException
     */
    public function execute(array $products): string
    {
        $openResult = $this->zip->open($this->getFilePath(), ZipArchive::CREATE);
        if ($openResult !== true) {
            $this->throwException($openResult);
        }

        $productCollection = new ProductCollection($products);
        foreach ($productCollection->notVariations() as $product) {
            $this->addProduct($product);
        }

        $this->zip->close();

        return $this->getFilePath();
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return void
     */
    private function addProduct(Product $product): void
    {
        $this->addProductFolder($product);
        $this->addProductData($product);
        $this->addProductMedia($product);
        $this->addProductVariations($product);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return void
     */
    private function addProductFolder(Product $product): void
    {
        $productFolder = $this->getZipProductFolder($product);
        $isAdded = $this->zip->addEmptyDir($productFolder);
        if (!$isAdded) {
            $this->throwException(null, $product);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return void
     */
    private function addProductData(Product $product): void
    {
        $productData = $this->getProductData($product);

        $isAdded = $this->zip->addFromString(
            $this->getZipProductDataFile($product),
            json_encode($productData->toArray(), JSON_UNESCAPED_UNICODE)
        );
        if (!$isAdded) {
            $this->throwException(null, $product);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return void
     */
    private function addProductMedia(Product $product): void
    {
        /** @var \Domain\Common\Models\CustomMedia $mainMedia */
        $mainMedia = $product->getFirstMedia(Product::MC_MAIN_IMAGE);
        if ($mainMedia) {
            $this->addMedia(
                $product,
                $mainMedia,
                $this->getZipProductMediaFile($product, $mainMedia, Product::MC_MAIN_IMAGE)
            );
        }

        $images = $product->getMedia(Product::MC_ADDITIONAL_IMAGES);
        foreach ($images as $imageMedia) {
            $this->addMedia(
                $product,
                $imageMedia,
                $this->getZipProductMediaFile($product, $imageMedia, Product::MC_ADDITIONAL_IMAGES)
            );
        }

        $files = $product->getMedia(Product::MC_FILES);
        foreach ($files as $fileMedia) {
            $this->addMedia(
                $product,
                $fileMedia,
                $this->getZipProductMediaFile($product, $fileMedia, Product::MC_FILES)
            );
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return void
     */
    private function addProductVariations(Product $product): void
    {
        foreach ($product->variations as $variation) {
            $this->addProductVariation($product, $variation);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return void
     */
    private function addProductVariation(Product $product, Product $variation): void
    {
        $this->addVariationFolder($product, $variation);
        $this->addVariationData($product, $variation);
        $this->addVariationMedia($product, $variation);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return void
     */
    private function addVariationFolder(Product $product, Product $variation): void
    {
        $isAdded = $this->zip->addEmptyDir(
            $this->getZipVariationFolder($product, $variation)
        );
        if (!$isAdded) {
            $this->throwException(null, $product);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return void
     */
    private function addVariationData(Product $product, Product $variation): void
    {
        $variationData = $this->getVariationData($variation);
        $isAdded = $this->zip->addFromString(
            $this->getZipVariationDataFile($product, $variation),
            json_encode($variationData->toArray(), JSON_UNESCAPED_UNICODE)
        );
        if (!$isAdded) {
            $this->throwException(null, $product);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return void
     */
    private function addVariationMedia(Product $product, Product $variation): void
    {
        /** @var \Domain\Common\Models\CustomMedia $mainMedia */
        $mainMedia = $variation->getFirstMedia(Product::MC_MAIN_IMAGE);
        if ($mainMedia) {
            $this->addMedia(
                $variation,
                $mainMedia,
                $this->getZipVariationMediaFile($product, $variation, $mainMedia, Product::MC_MAIN_IMAGE)
            );
        }

        $images = $variation->getMedia(Product::MC_ADDITIONAL_IMAGES);
        foreach ($images as $imageMedia) {
            $this->addMedia(
                $variation,
                $imageMedia,
                $this->getZipVariationMediaFile($product, $variation, $imageMedia, Product::MC_ADDITIONAL_IMAGES)
            );
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Common\Models\CustomMedia $media
     * @param string $zipPath
     *
     * @return void
     */
    private function addMedia(Product $product, CustomMedia $media, string $zipPath): void
    {
        $isAdded = $this->zip->addFile( // TODO think of adding files from AWS or yandex
            $media->getPath(),
            $zipPath
        );

        if (!$isAdded) {
            $this->throwException(null, $product, $media);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return \Domain\Products\DTOs\ExportProductDTO
     */
    private function getProductData(Product $product): ExportProductDTO
    {
        return ExportProductDTO::fromModel($product);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return \Domain\Products\DTOs\ExportVariationDTO
     */
    private function getVariationData(Product $variation): ExportVariationDTO
    {
        return ExportVariationDTO::fromModel($variation);
    }

    /**
     * Full path to generating / generated .zip archive
     *
     * @return string
     */
    private function getFilePath(): string
    {
        return sprintf('%s/%s', $this->basePath, $this->name);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return string
     */
    private function getZipProductFolder(Product $product): string
    {
        return $product->uuid;
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return string
     */
    private function getZipVariationFolder(Product $product, Product $variation): string
    {
        return sprintf('%s/variations/%s', $this->getZipProductFolder($product), $variation->uuid);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return string
     */
    private function getZipProductDataFile(Product $product): string
    {
        return sprintf('%s/%s', $this->getZipProductFolder($product), static::PRODUCT_DATA_FILE_NAME);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Common\Models\CustomMedia $media
     * @param string $type
     *
     * @return string
     */
    private function getZipProductMediaFile(Product $product, CustomMedia $media, string $type): string
    {
        return sprintf(
            '%s/media/%s/%s/%s',
            $this->getZipProductFolder($product),
            $type,
            $media->id,
            $media->file_name
        );
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product $variation
     * @param \Domain\Common\Models\CustomMedia $media
     * @param string $type
     *
     * @return string
     */
    private function getZipVariationMediaFile(Product $product, Product $variation, CustomMedia $media, string $type): string
    {
        return sprintf(
            '%s/media/%s/%s/%s',
            $this->getZipVariationFolder($product, $variation),
            $type,
            $media->id,
            $media->file_name
        );
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return string
     */
    private function getZipVariationDataFile(Product $product, Product $variation): string
    {
        return sprintf('%s/%s', $this->getZipVariationFolder($product, $variation), static::VARIATION_DATA_FILE_NAME);
    }

    /**
     * @param int|null $errCode
     * @param \Domain\Products\Models\Product\Product|null $product
     * @param \Domain\Common\Models\CustomMedia|null $media
     */
    private function throwException(int $errCode = null, Product $product = null, CustomMedia $media = null)
    {
        throw new ExportProductException(
            sprintf(
                'Failed to export products: `%s`. %s %s %s',
                $this->zip->getStatusString(),
                $errCode ? sprintf('Error code: %s.', $errCode) : '',
                $product ? sprintf('Product: id %s, name %s', $product->id, $product->name) : '',
                $media ? sprintf('Media file: id %s', $media->id) : ''
            )
        );
    }
}
