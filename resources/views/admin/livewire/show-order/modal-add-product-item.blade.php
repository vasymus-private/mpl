<?php
/**
 * @var \App\Http\Livewire\Admin\ShowOrder\ShowOrder $this
 * @var array[] $categoriesSidebar @see {@link \App\View\Components\Admin\SidebarMenuComponent[]}
 */
?>
<div wire:ignore.self class="modal fade" id="add-product-item" tabindex="-1" aria-labelledby="add-product-item-title" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-product-item-title">Каталог товаров</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                <div class="row d-flex flex-grow-1 row-overflow-hidden">
                    <div class="content col-8 order-2">
                        @include('admin.livewire.includes.form-search', [
                            'submit' => 'handleSearchAddProductItem',
                            'clearAll' => 'clearAllFilters',
                            'prepends' => $this->getProductItemsFilters(),
                        ])
                    </div>
                    <aside wire:ignore class="sidebar-left p-0 col-4 order-1">
                        <nav class="min-vh-100 js-admin-sidbar">
                            <ul class="nav pt-3">
                                <li class="nav-item">
                                    <a href="#modal-categories" class="nav-link" data-toggle="collapse" role="button" aria-expanded="true">
                                        <span class="adm-arrow-icon"></span>
                                        <span class="adm-icon iblock_menu_icon_types"></span>
                                        <span class="nav-link-text">Каталог товаров</span>
                                    </a>
                                    <ul class="nav collapse show" id="modal-categories">
                                        @foreach($categoriesSidebar as $category)
                                            <li class="nav-item">
                                                <a href="#modal-categories-{{$category['id']}}" class="nav-link collapsed sub-level-2" data-toggle="collapse" role="button" aria-expanded="false">
                                                    <span class="adm-arrow-icon"></span>
                                                    <span  wire:click="setProductItemFilter({{$category['id']}})" class="d-flex align-items-center justify-content-center js-navigate-categories">
                                                        <span class="adm-icon iblock_menu_icon_sections"></span>
                                                        <span class="nav-link-text">{{$category['name']}}</span>
                                                    </span>
                                                </a>
                                                <ul class="nav collapse" id="modal-categories-{{$category['id']}}">
                                                    @foreach($category['subcategories'] as $subcategory1)
                                                        <li class="nav-item">
                                                            <a href="#modal-categories-{{$subcategory1['id']}}" class="nav-link collapsed sub-level-3" data-toggle="collapse" role="button" aria-expanded="false">
                                                                @if(!empty($subcategory1['subcategories']))
                                                                    <span class="adm-arrow-icon"></span>
                                                                @else
                                                                    <span class="adm-arrow-icon-dot"></span>
                                                                @endif
                                                                <span wire:click="setProductItemFilter({{$subcategory1['id']}})"  class="d-flex align-items-center justify-content-center js-navigate-categories">
                                                                    <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                    <span class="nav-link-text">{{$subcategory1['name']}}</span>
                                                                </span>
                                                            </a>
                                                            @if(!empty($subcategory1['subcategories']))
                                                            <ul class="nav collapse" id="modal-categories-{{$subcategory1['id']}}">
                                                                @foreach($subcategory1['subcategories'] as $subcategory2)
                                                                    <li class="nav-item">
                                                                        <a href="#modal-categories-{{$subcategory2['id']}}" class="nav-link collapsed sub-level-4" data-toggle="collapse" role="button" aria-expanded="false">
                                                                            @if(!empty($subcategory2['subcategories']))
                                                                                <span class="adm-arrow-icon"></span>
                                                                            @else
                                                                                <span class="adm-arrow-icon-dot"></span>
                                                                            @endif
                                                                            <span wire:click="setProductItemFilter({{$subcategory2['id']}})" class="d-flex align-items-center justify-content-center js-navigate-categories">
                                                                                <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                                <span class="nav-link-text">{{$subcategory2['name']}}</span>
                                                                            </span>
                                                                        </a>
                                                                        @if(!empty($subcategory2['subcategories']))
                                                                        <ul class="nav collapse" id="modal-categories-{{$subcategory2['id']}}">
                                                                            @foreach($subcategory2['subcategories'] as $subcategory3)
                                                                                <li class="nav-item">
                                                                                    <a href="#modal-categories-{{$subcategory3['id']}}" class="nav-link sub-level-5" data-toggle="collapse" role="button" aria-expanded="true">
                                                                                        <span class="adm-arrow-icon-dot"></span>
                                                                                        <span wire:click="setProductItemFilter({{$subcategory3['id']}})" class="d-flex align-items-center justify-content-center js-navigate-categories">
                                                                                            <span class="adm-icon iblock_menu_icon_sections"></span>
                                                                                            <span class="nav-link-text">{{$subcategory3['name']}}</span>
                                                                                        </span>
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </aside>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
