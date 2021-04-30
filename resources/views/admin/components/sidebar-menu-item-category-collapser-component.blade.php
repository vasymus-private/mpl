<?php
/**
 * @see \App\View\Components\Admin\SidebarMenuItemCategoryCollapserComponent::href()
 * @var string|\Illuminate\View\InvokableComponentVariable $href
 *
 * @see \App\View\Components\Admin\SidebarMenuItemCategoryCollapserComponent::isActive()
 * @var bool|\Illuminate\View\InvokableComponentVariable $isActive
 *
 * @see \App\View\Components\Admin\SidebarMenuItemCategoryCollapserComponent::ariaControls()
 * @var string|\Illuminate\View\InvokableComponentVariable $ariaControls
 *
 * @see \App\View\Components\Admin\SidebarMenuItemCategoryCollapserComponent::ariaExpanded()
 * @var string|\Illuminate\View\InvokableComponentVariable $ariaExpanded
 *
 * @see \App\View\Components\Admin\SidebarMenuItemCategoryCollapserComponent::text()
 * @var \Illuminate\Support\HtmlString|\Illuminate\View\InvokableComponentVariable $text
 */
?>
<a
    href="{{$href}}"
    data-toggle="collapse"
    role="button"
    aria-expanded="{{$ariaExpanded}}"
    aria-controls="{{$ariaControls}}"
    {{ $attributes->class(["active" => $isActive(), "collapsed" => !($isActive())]) }}
>
	{{ $slot }}
	{{$text}}
</a>
