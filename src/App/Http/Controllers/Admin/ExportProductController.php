<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Jobs\ExportProductsJob;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExportProductController extends BaseAdminController
{
    public function index()
    {
        $centralAdmin = Admin::getCentralAdmin();
        $mediaItems = $centralAdmin->getMedia(Admin::MC_EXPORT_PRODUCTS)->sortByDesc('created_at')->all();

        return view('admin.pages.export.products', compact('mediaItems'));
    }

    public function show(Request $request)
    {
        $centralAdmin = Admin::getCentralAdmin();
        /** @var \Domain\Common\Models\CustomMedia $media */
        $media = $centralAdmin->getFirstMedia(Admin::MC_EXPORT_PRODUCTS, ['id' => $request->media_id]);
        if (!$media) {
            throw (new ModelNotFoundException)->setModel(
                get_class(CustomMedia::class), $request->media_id
            );
        }

        return response()->download($media->getPath(), $media->file_name, [
            'Content-Type: application/octet-stream',
            sprintf('Content-Length: %s', filesize($media->getPath())),
        ]);
    }

    public function store(Request $request)
    {
        $products = Product::query()
            ->notVariations()
            ->with([
                'media',
                'variations.media',
                'accessory',
                'similar',
                'related',
                'works',
                'instruments',
                'category',
                'relatedCategories',
                'infoPrices',
                'seo',
                'charCategories.chars',
            ])
            ->get();

        ExportProductsJob::dispatch($products);

        return redirect()
            ->route(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW)
            ->with('message', 'Осуществляется процесс по формированию .zip архива с импортируемыми товарами. Через несколько минут он появится в таблице.');
    }
}
