<script lang="ts" setup>
import FormGroupCheckBox from '@/admin/inertia/components/forms/vee-validate/FormGroupCheckBox.vue'
import FormGroupInput from '@/admin/inertia/components/forms/vee-validate/FormGroupInput.vue'
import {isCreatingProductRoute, useProductsStore} from "@/admin/inertia/modules/products"
import {computed, ref, watch} from "vue"
import {slugify} from "@/admin/inertia/modules/common"
import {useFormsStore} from "@/admin/inertia/modules/forms"


const productsStore = useProductsStore()
const formsStore = useFormsStore()

const isCreating = computed(() => isCreatingProductRoute())
const generateSlugSyncMode = ref(false)

watch(generateSlugSyncMode, newV => {
    if (newV) {
        handleSyncNameAndSlug()
    }
})
const handleSyncNameAndSlug = async () => {
    if (!generateSlugSyncMode.value) {
        return
    }

    if (!formsStore.product.name) {
        return
    }

    productsStore.updateProduct({
        slug: await slugify(formsStore.product.name)
    })
}
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!isCreating" class="form-group row">
            <label for="item.name" class="col-sm-5 col-form-label">ID:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{ productsStore.product?.id }}
            </div>
        </div>

        <FormGroupCheckBox name="is_active" label="Активность" />

        <FormGroupInput
            name="name"
            label="Название"
            label-class="fw-bold"
            input-group
            @blur="handleSyncNameAndSlug"
        >
            <template #input-group-append>
                <div class="input-group-append">
                    <button
                        @click="generateSlugSyncMode = !generateSlugSyncMode"
                        class="btn btn-outline-secondary"
                        type="button"
                    ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                </div>
            </template>
        </FormGroupInput>

        <FormGroupInput
            name="slug"
            label="Символьный код"
            label-class="fw-bold"
            input-group
        >
            <template #input-group-append>
                <div class="input-group-append">
                    <button
                        @click="generateSlugSyncMode = !generateSlugSyncMode"
                        class="btn btn-outline-secondary"
                        type="button"
                    ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                </div>
            </template>
        </FormGroupInput>

        <FormGroupInput name="ordering" label="Сортировка" input-col-class="col-sm-7 width-27"/>
    </div>
</template>
