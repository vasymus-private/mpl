<script lang="ts" setup>
import {defineProps} from 'vue'
import {Link} from "@inertiajs/inertia-vue3"


const props = defineProps<{
    total: number,
    sizes?: Array<number>,
}>()
</script>

<template>
    <div class="block-pagination">
<!--        <div class="row">-->
<!--            <div :class="`col-sm-${props.sizes ? props.sizes[0] : 10} row-line`">-->
<!--                <span class="block-pagination__text">Всего: {{props.total}}</span>-->
<!--                <div>-->
<!--                    @if ($paginator->hasPages())-->
<!--                    <nav>-->
<!--                        <ul class="pagination">-->
<!--                            {{&#45;&#45; Previous Page Link &#45;&#45;}}-->
<!--                            @if ($paginator->onFirstPage())-->
<!--                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">-->
<!--                                <span class="page-link" aria-hidden="true">&lsaquo;</span>-->
<!--                            </li>-->
<!--                            @else-->
<!--                            <li class="page-item">-->
<!--                                <button type="button" dusk="previousPage" class="page-link" wire:click="previousPage" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</button>-->
<!--                            </li>-->
<!--                            @endif-->

<!--                            {{&#45;&#45; Pagination Elements &#45;&#45;}}-->
<!--                            @foreach ($elements as $element)-->
<!--                            {{&#45;&#45; "Three Dots" Separator &#45;&#45;}}-->
<!--                            @if (is_string($element))-->
<!--                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>-->
<!--                            @endif-->

<!--                            {{&#45;&#45; Array Of Links &#45;&#45;}}-->
<!--                            @if (is_array($element))-->
<!--                            @foreach ($element as $page => $url)-->
<!--                            @if ($page == $paginator->currentPage())-->
<!--                            <li class="page-item active" wire:key="paginator-page-{{ $page }}" aria-current="page"><span class="page-link">{{ $page }}</span></li>-->
<!--                            @else-->
<!--                            <li class="page-item" wire:key="paginator-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>-->
<!--                            @endif-->
<!--                            @endforeach-->
<!--                            @endif-->
<!--                            @endforeach-->

<!--                            {{&#45;&#45; Next Page Link &#45;&#45;}}-->
<!--                            @if ($paginator->hasMorePages())-->
<!--                            <li class="page-item">-->
<!--                                <button type="button" dusk="nextPage" class="page-link" wire:click="nextPage" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</button>-->
<!--                            </li>-->
<!--                            @else-->
<!--                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">-->
<!--                                <span class="page-link" aria-hidden="true">&rsaquo;</span>-->
<!--                            </li>-->
<!--                            @endif-->
<!--                        </ul>-->
<!--                    </nav>-->
<!--                    @endif-->
<!--                </div>-->

<!--            </div>-->
<!--            <div :class="`col-sm-${props.sizes ? props.sizes[1] : 2}`">-->
<!--                @if($formGroup ?? true)-->
<!--                @include('-->
<!--                admin.livewire.includes.form-group-select',-->
<!--                array_merge([-->
<!--                'field' => 'per_page',-->
<!--                'label' => 'На странице',-->
<!--                'nullOption' => false,-->
<!--                ], compact('options', 'wire'))-->
<!--                )-->
<!--                @else-->
<!--                @include(-->
<!--                'admin.livewire.includes.form-control-select',-->
<!--                array_merge([-->
<!--                'field' => 'per_page',-->
<!--                'nullOption' => false,-->
<!--                ], compact('options', 'wire'))-->
<!--                )-->
<!--                @endif-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>
