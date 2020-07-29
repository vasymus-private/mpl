<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemsController extends BaseWebController
{
    public function index(Request $request)
    {
        $categories = Category::parents()->with("subcategories.subcategories.subcategories")->orderBy(Category::TABLE . ".ordering")->get();
        $galleryItems = GalleryItem::parents()->orderBy(GalleryItem::TABLE . ".ordering")->get();
        $subtitle = "Фотогалерея паркетных работ";

        return view("web.gallery-items", compact("galleryItems", "subtitle", "categories"));
    }

    public function show(Request $request)
    {
        $categories = Category::parents()->with("subcategories.subcategories.subcategories")->orderBy(Category::TABLE . ".ordering")->get();

        /** @var GalleryItem $parentGalleryItem */
        $parentGalleryItem = $request->parentGalleryItemSlug;
        $parentGalleryItem->load("child");
        $childGalleryItems = $parentGalleryItem->child;
        $subtitle = $parentGalleryItem->name;

        return view("web.gallery-item", compact("subtitle", "childGalleryItems", "categories"));
    }
}
