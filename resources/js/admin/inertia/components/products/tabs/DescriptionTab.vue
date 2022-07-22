<script lang="ts" setup>
import {Field, useField} from "vee-validate"
import {computed} from "vue"
import AppHtmlEditor from '@/admin/inertia/components/forms/AppHtmlEditor.vue'
import {useProductsStore} from "@/admin/inertia/modules/products"
import {getRouteUrl, routeNames} from "@/admin/inertia/modules/routes"


const productsStore = useProductsStore()
const {setValue, value} = useField('preview')
const preview = computed({
    get() {
        return value.value || null
    },
    set(nv) {
        return setValue(nv)
    }
})
const uploadUrl = computed(() => {
    return productsStore.product?.id ? getRouteUrl(routeNames.ROUTE_ADMIN_PRODUCT_IMAGE_UPLOAD, productsStore.product?.id) : null
})
</script>

<template>
    <div class="item-edit product-edit">
        <div class="h2">Описание для анонса</div>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="preview-html-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#preview-html"
                    type="button"
                    role="tab"
                    aria-controls="preview-html"
                    aria-selected="false"
                >HTML</button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="preview-editor-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#preview-editor"
                    type="button"
                    role="tab"
                    aria-controls="preview-editor"
                    aria-selected="true"
                >Визуальный редактор</button>
            </li>
        </ul>

        <div class="tab-content" id="nav-preview-tab-content">
            <div class="tab-pane fade" style="height: 600px" id="preview-html" role="tabpanel" aria-labelledby="preview-html-tab">
                <Field
                    v-slot="{field, meta}"
                    name="preview"
                >
                    <textarea
                        v-bind="field"
                        :class="['form-control', 'h-100', !meta.valid ? 'is-invalid' : '']"
                        id="preview"
                        rows="3"
                    />
                </Field>
            </div>
            <div class="tab-pane fade show active" id="preview-editor" role="tabpanel" aria-labelledby="preview-editor-tab">
                <AppHtmlEditor
                    v-model="preview"
                    :upload-url="uploadUrl"
                />
            </div>
        </div>
    </div>
</template>
