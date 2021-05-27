<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ShowBrand extends Component
{
    use WithFileUploads;

    protected const MAX_FILE_SIZE_MB = 30;

    protected const DEFAULT_TAB = 'elements';

    /**
     * @var \Domain\Products\Models\Brand
     */
    public Brand $brand;

    /**
     * @var \Domain\Seo\Models\Seo
     */
    public Seo $seo;

    /**
     * @var array|null @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $mainImage = [];

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempMainImage;

    /**
     * @var string
     */
    public string $activeTab;

    /**
     * @var bool
     */
    public bool $generateSlugSyncMode = false;

    /**
     * @var string[]
     */
    public array $tabs = [
        'elements' => 'Элемент',
        'description' => 'Описание',
        'photo' => 'Фото',
        'seo' => 'SEO',
    ];

    /**
     * @var array
     */
    protected array $rules = [
        'brand.name' => 'required|string|max:199',
        'brand.slug' => 'nullable|string|max:199',
        'brand.ordering' => 'integer|nullable',
        'brand.preview' => 'nullable|max:65000',
        'brand.description' => 'nullable|max:65000',

        'seo.title' => 'nullable|max:199',
        'seo.h1' => 'nullable|max:199',
        'seo.keywords' => 'nullable|max:65000',
        'seo.description' => 'nullable|max:65000',

        'tempMainImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
    ];

    protected static function getActiveTabCacheKey(int $id = null): string
    {
        return auth()->id() . '-' . $id . '-show-brand-active-tab';
    }

    public function mount()
    {
        /** @var \Domain\Common\Models\CustomMedia $mainImageMedia */
        $mainImageMedia = $this->brand->getFirstMedia(Product::MC_MAIN_IMAGE);
        $this->mainImage = $mainImageMedia ? FileDTO::fromCustomMedia($mainImageMedia)->toArray() : [];

        $this->activeTab = Cache::get(static::getActiveTabCacheKey($this->brand->id), self::DEFAULT_TAB);

        $this->seo = $this->brand->seo ?: new Seo();
    }

    public function render()
    {
        return view('admin.livewire.show-brand.show-brand');
    }

    public function save()
    {
        $this->validate();

        $shouldRedirect = false;
        if (!$this->brand->id) {
            $shouldRedirect = true;
        }

        $this->saveBrand();

        $this->saveMainImage();

        $this->saveSeo();

        if ($shouldRedirect) {
            return redirect()->route('admin.brands.edit', $this->brand->id);
        }
    }

    protected function saveBrand()
    {
        $this->brand->save();
    }

    protected function saveMainImage()
    {
        if (!$this->mainImage) {
            /** @var CustomMedia|null $media */
            $media = $this->brand->getFirstMedia(Brand::MC_MAIN_IMAGE);
            if ($media) $media->delete();
            return;
        }

        if ($this->mainImage['id'] !== null) {
            /** @var CustomMedia|null $media */
            $media = $this->brand->getFirstMedia(Brand::MC_MAIN_IMAGE);
            if ($media) {
                $media->name = $this->mainImage['name'];
                $media->save();
            }
        } else {
            $mainImage = new FileDTO($this->mainImage);

            $fileAdder = $this->brand
                ->addMedia($mainImage->path)
                ->preservingOriginal()
                ->usingFileName($mainImage->file_name)
                ->usingName($mainImage->name ?? $mainImage->file_name)
            ;

            $fileAdder->toMediaCollection(Brand::MC_MAIN_IMAGE);
        }
    }

    protected function saveSeo()
    {
        $this->brand->seo()->save($this->seo);
    }

    public function selectTab(string $tab)
    {
        if (in_array($tab, array_keys($this->tabs))) {
            Cache::put(static::getActiveTabCacheKey($this->brand->id), $tab, new \DateInterval('PT15M'));
        }
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempMainImage(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->mainImage = $fileDTO->toArray();
    }

    public function updatedBrandName()
    {
        $this->handleGenerateSlug();
    }

    public function toggleGenerateSlugMode()
    {
        $this->generateSlugSyncMode = !$this->generateSlugSyncMode;
        $this->handleGenerateSlug();
    }

    public function handleGenerateSlug()
    {
        if ($this->generateSlugSyncMode) {
            $this->generateSlug();
        }
    }

    protected function generateSlug()
    {
        $this->brand->slug = Str::slug($this->brand->name);
    }

    public function deleteMainImage()
    {
        $this->mainImage = [];
    }
}
