<script lang="ts" setup>
import {isCreatingProductRoute, useProductsStore} from "@/admin/inertia/modules/products"
import {computed, ref, watch} from "vue"
import {slugify} from "@/admin/inertia/modules/common"
import {useFormsStore} from "@/admin/inertia/modules/forms"
import {useBrandsStore} from "@/admin/inertia/modules/brands"
import { Field } from 'vee-validate'


const productsStore = useProductsStore()
const formsStore = useFormsStore()
const brandsStore = useBrandsStore()

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
        <div v-if="!isCreating" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ productsStore.product?.id }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="is_active">Активность:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="is_active"
                    type="checkbox"
                    :value="true"
                >
                    <input
                        v-bind="field"
                        name="is_active"
                        type="checkbox"
                        :value="true"
                        id="is_active"
                        :class="['form-check-input', !meta.valid ? 'is-invalid' : '']"
                    />
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="name" class="fw-bold">Название:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="name"
                >
                    <div :class="['input-group', !meta.valid ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                            type="text"
                            id="name"
                            @blur="handleSyncNameAndSlug"
                        />
                        <div class="input-group-append">
                            <button
                                @click="generateSlugSyncMode = !generateSlugSyncMode"
                                class="btn btn-outline-secondary"
                                type="button"
                            ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="slug" class="fw-bold">Символьный код:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="slug"
                >
                    <div :class="['input-group', !meta.valid ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                            type="text"
                            id="slug"
                        />
                        <div class="input-group-append">
                            <button
                                @click="generateSlugSyncMode = !generateSlugSyncMode"
                                class="btn btn-outline-secondary"
                                type="button"
                            ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="ordering">Сортировка:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{field, meta}"
                    name="ordering"
                >
                    <input
                        v-bind="field"
                        :class="['form-control', 'width-27', !meta.valid ? 'is-invalid' : '']"
                        type="number"
                        id="ordering"
                    />
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="brand_id">Производитель:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{field, meta}"
                    name="brand_id"
                >
                    <select
                        :class="['form-control', !meta.valid ? 'is-invalid' : '' ]"
                        id="brand_id"
                        v-bind="field"
                    >
                        <option :value="undefined">(не установлено)</option>
                        <option
                            v-for="option in brandsStore.options"
                            :key="option.value"
                            :value="option.value"
                            :disabled="option.disabled"
                        >{{option.label}}</option>
                    </select>
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="coefficient">Коэффициент на единицу расхода:</label>
            </div>
            <div class="col-sm-1">
                <Field
                    v-slot="{field, meta}"
                    name="coefficient"
                >
                    <input
                        v-bind="field"
                        :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                        type="number"
                        id="coefficient"
                    />
                </Field>
            </div>
            <div class="col-sm-3 text-end">
                <label for="coefficient_description">Описание коэффициента:</label>
            </div>
            <div class="col-sm-3">
                <Field
                    v-slot="{field, meta}"
                    name="coefficient_description"
                >
                    <input
                        v-bind="field"
                        :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                        type="text"
                        id="coefficient_description"
                    />
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="coefficient_description_show">Показывать описание коэффициента:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="coefficient_description_show"
                    type="checkbox"
                    :value="true"
                >
                    <input
                        v-bind="field"
                        name="coefficient_description_show"
                        type="checkbox"
                        :value="true"
                        id="coefficient_description_show"
                        :class="['form-check-input', !meta.valid ? 'is-invalid' : '']"
                    />
                </Field>
            </div>
        </div>

    </div>
</template>
