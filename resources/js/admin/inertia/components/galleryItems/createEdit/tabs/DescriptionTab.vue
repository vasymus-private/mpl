<script lang="ts" setup>
import {useRoutesStore} from "@/admin/inertia/modules/routes"
import Description from "@/admin/inertia/components/forms/parts/Description.vue"


const routesStore = useRoutesStore()
</script>

<template>
    <div class="item-edit product-edit">
        <Description
            id="description"
            label="Описание"
            name="description"
        />
    </div>
</template>
