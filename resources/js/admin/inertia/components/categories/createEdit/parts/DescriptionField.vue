<script setup lang="ts">
import {useField, Field} from "vee-validate"
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {computed} from "vue"
import {getRouteUrl, routeNames} from "@/admin/inertia/modules/routes"
import AppHtmlEditor from '@/admin/inertia/components/forms/parts/AppHtmlEditor.vue'


const categoriesStore = useCategoriesStore()
const {setValue : setDescriptionValue, value : descriptionValue} = useField<string|null>('description')
const description = computed({
    get() {
        return descriptionValue.value || null
    },
    set(nv) {
        return setDescriptionValue(nv)
    }
})
const uploadUrl = computed(() => {
    return categoriesStore.category?.id
        ? getRouteUrl(routeNames.ROUTE_ADMIN_AJAX_CATEGORY_IMAGE_UPLOAD, {admin_category: categoriesStore.category?.id})
        : null
})
</script>

<template>
    <div>
        <div class="h2">Описание</div>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="description-html-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#description-html"
                    type="button"
                    role="tab"
                    aria-controls="description-html"
                    aria-selected="false"
                >HTML</button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="description-editor-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#description-editor"
                    type="button"
                    role="tab"
                    aria-controls="description-editor"
                    aria-selected="true"
                >Визуальный редактор</button>
            </li>
        </ul>

        <div class="tab-content" id="nav-description-tab-content">
            <div class="tab-pane fade" style="height: 600px" id="description-html" role="tabpanel" aria-labelledby="description-html-tab">
                <Field
                    v-slot="{field, meta}"
                    name="description"
                >
                    <textarea
                        v-bind="field"
                        :class="['form-control', 'h-100', !meta.valid ? 'is-invalid' : '']"
                        id="description"
                        rows="3"
                    />
                </Field>
            </div>
            <div class="tab-pane fade show active" id="description-editor" role="tabpanel" aria-labelledby="description-editor-tab">
                <AppHtmlEditor
                    v-model="description"
                    :upload-url="uploadUrl"
                />
            </div>
        </div>
    </div>
</template>
