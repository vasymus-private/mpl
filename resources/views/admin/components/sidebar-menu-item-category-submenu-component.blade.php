<?php
/**
 * @see \App\View\Components\Admin\SidebarMenuItemCategorySubmenuComponent::id()
 * @var string|\Illuminate\View\InvokableComponentVariable $id
 *
 * @see \App\View\Components\Admin\SidebarMenuItemCategorySubmenuComponent::isActive()
 * @var string|\Illuminate\View\InvokableComponentVariable $isActive
 */
?>
<ul id="{{$id}}" {{ $attributes->class(["collapse", "show" => $isActive()]) }}>
    {{ $slot }}
</ul>
