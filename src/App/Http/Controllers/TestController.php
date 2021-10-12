<?php

namespace App\Http\Controllers;

use App\Mail\TestMarkupOrderShippedMail;
use App\Mail\TestMarkupResetPasswordMail;
use Domain\Products\Actions\ExportImport\ExportProductsAction;
use Domain\Products\Jobs\ExportProductsJob;
use Domain\Products\Models\Product\Product;
use Domain\Temp\User;
use Domain\Users\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\File;
use Support\H;

class TestController extends Controller
{
    public function test(Request $request, ExportProductsAction $exportProductsAction)
    {
//        $fileName = '/tmp/ziprxk684';
//        $configFileSize = config('media-library.max_file_size');
//        $tempFileFileSize = filesize($fileName) + 1024 * 10; // + buffer just for case
//        config()->set('media-library.max_file_size', $tempFileFileSize);
//        $centralAdmin = Admin::getCentralAdmin();
//        /** @var \Domain\Common\Models\CustomMedia $media */
//        $media = $centralAdmin
//            ->addMedia($fileName)
//            ->setFileName('dddd.zip')
//            ->toMediaCollection(Admin::MC_EXPORT_PRODUCTS);
//        config()->set('media-library.max_file_size', $configFileSize);
//
//        dump($media);

        //dump(get_current_user(), getmyuid(), getmygid(), getmypid());

//        H::logInfo();
        // Log::info('hello');

        //dump(\Spatie\MediaLibrary\Support\File::getMimeType('/var/www/html/storage/app/media/6389/product-export--2021-10-12--17-36-22.zip'));

        return view('test');
    }

    protected function testForOleh()
    {
        /** @var \Domain\Temp\User $user */
        $user = User::query()->first();

        $productsIds = $user->sections()->select('sections.product_id')->groupBy('sections.product_id')->pluck('sections.product_id');

        $sections = $user->sections()->select([
            'sections.id as section_id',
            't1.id as parent_1_section_id',
            't2.id as parent_2_section_id',
        ])
            ->leftJoin('sections as t1', 'sections.parent_id', '=', 't1.id')
            ->leftJoin('sections as t2', 't1.parent_id', '=', 't2.id')
            ->groupBy(['sections.id', 't1.id', 't2.id'])
            ->get();

        $sectionsIds = $sections->reduce(function(array $acc, Model $model) {
            if ($model->section_id) $acc[] = $model->section_id;
            if ($model->parent_1_section_id) $acc[] = $model->parent_1_section_id;
            if ($model->parent_2_section_id) $acc[] = $model->parent_2_section_id;

            return $acc;
        }, []);

        $sectionsIds = array_values(array_unique($sectionsIds));

        $products = Product::query()->with([
            'sections' => function(HasMany $query) use($sectionsIds) {
                $query->whereIn('id', $sectionsIds);
            },
            'sections.subsections' => function(HasMany $query) use($sectionsIds) {
                $query->whereIn('id', $sectionsIds);
            },
            'sections.subsections.subsections' => function(HasMany $query) use($sectionsIds) {
                $query->whereIn('id', $sectionsIds);
            },
        ])->whereIn('id', $productsIds)->get();

        dump($products);


//        $products = $user->sections->reduce(function(array $acc, Section $section) {
//            $acc[] = $section->product;
//            return $acc;
//        }, []);
//        $products = collect($products)->unique(function(Product $product) {
//            return $product->id;
//        })->values()->all();
//
//        dump($products);
    }

    protected function testRule()
    {
        /*$validator = Validator::make(
            [
                "search" => "",
                "category_id" => "",
                "category_name" => "Раздел: Верхний уровень",
                "editMode" => true,
                "categories" => [
                    1 => [
                        "id" => 1,
                        "name" => "Паркет243",
                        "ordering" => 100,
                        "is_active" => false,
                        "is_active_name" => "Да",
                        "is_checked" => false,
                        "hasSubcategories" => true,
                    ],
                    8 => [
                        "id" => 8,
                        "name" => "Паркетны111",
                        "ordering" => 20,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => true,
                        "hasSubcategories" => true,
                    ],
                    19 => [
                        "id" => 19,
                        "name" => "Паркетный afgadgasd",
                        "ordering" => 300,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => true,
                        "hasSubcategories" => true,
                    ],
                    31 => [
                        "id" => 31,
                        "name" => "SDFS",
                        "ordering" => 4005,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => false,
                        "hasSubcategories" => true,
                    ],
                    36 => [
                        "id" => 36,
                        "name" => "Шпаклевка",
                        "ordering" => 450,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => false,
                        "hasSubcategories" => true,
                    ],
                    39 => [
                        "id" => 39,
                        "name" => "Средства по уходу",
                        "ordering" => 500,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => false,
                        "hasSubcategories" => true,
                    ],
                    46 => [
                        "id" => 46,
                        "name" => "Основание пола",
                        "ordering" => 600,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => false,
                        "hasSubcategories" => true,
                    ],
                    54 => [
                        "id" => 54,
                        "name" => "Оборудование",
                        "ordering" => 700,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => false,
                        "hasSubcategories" => true,
                    ],
                    60 => [
                        "id" => 60,
                        "name" => "Сопутствующие товары",
                        "ordering" => 800,
                        "is_active" => true,
                        "is_active_name" => "Да",
                        "is_checked" => false,
                        "hasSubcategories" => true,
                    ],
                ],
                "selectAll" => false
            ],
            [
                'categories.*.is_active' => [new CategoryDeactivatable()]
            ]
        );

        dump($validator->fails());*/
    }

    public function testImages()
    {
        $product = Product::query()->find(6);

//        dump(Product::query()->find(6)->images_urls);
//        dump(Product::query()->find(6)->images_xs_thumbs_urls);
//        dump(Product::query()->find(6)->images_sm_thumbs_urls);
//        dump(Product::query()->find(6)->images_md_thumbs_urls);
//        dump(Product::query()->find(6)->images_lg_thumbs_urls);

        $images = array_merge([], $product->images_urls, $product->images_xs_thumbs_urls, $product->images_sm_thumbs_urls, $product->images_md_thumbs_urls, $product->images_lg_thumbs_urls);

        return view('test', compact("images"));
    }

    public function testEmailOrder()
    {

    }

    public function testEmailOrderMarkup()
    {
        return new TestMarkupOrderShippedMail();
    }

    public function testResetPasswordMarkup()
    {
        return new TestMarkupResetPasswordMail();
    }

    /**
     * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
     *
     * @param string $text String to truncate.
     * @param integer $length Length of returned string, including ellipsis.
     * @param string $ending Ending to be appended to the trimmed string.
     * @param boolean $exact If false, $text will not be cut mid-word
     * @param boolean $considerHtml If true, HTML tags would be handled correctly
     *
     * @return string Trimmed string.
     */
    function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            // splits all html-tags to scanable lines
            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($line_matchings[1])) {
                    // if it's an "empty element" with or without xhtml-conform closing slash
                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                        // do nothing
                        // if tag is a closing tag
                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                        // delete tag from $open_tags list
                        $pos = array_search($tag_matchings[1], $open_tags);
                        if ($pos !== false) {
                            unset($open_tags[$pos]);
                        }
                        // if tag is an opening tag
                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                        // add tag to the beginning of $open_tags list
                        array_unshift($open_tags, strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate'd text
                    $truncate .= $line_matchings[1];
                }
                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length+$content_length> $length) {
                    // the number of characters which are left
                    $left = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($entity[1]+1-$entities_length <= $left) {
                                $left--;
                                $entities_length += strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                } else {
                    $truncate .= $line_matchings[2];
                    $total_length += $content_length;
                }
                // if the maximum length is reached, get off the loop
                if($total_length>= $length) {
                    break;
                }
            }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = substr($text, 0, $length - strlen($ending));
            }
        }
        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = substr($truncate, 0, $spacepos);
            }
        }
        // add the defined ending to the text
        $truncate .= $ending;
        if($considerHtml) {
            // close all unclosed html-tags
            foreach ($open_tags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }
        return $truncate;
    }
}
