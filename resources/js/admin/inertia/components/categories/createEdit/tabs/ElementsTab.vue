<script lang="ts" setup>
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import {useCreateEditCategoryFormStore} from "@/admin/inertia/modules/forms/createEditCategory"
import DescriptionField from '@/admin/inertia/components/categories/createEdit/parts/DescriptionField.vue'
import {ref, watch} from "vue"
import {useField} from "vee-validate"
import {slugify} from "@/admin/inertia/modules/common"


const createEditCategoryFormStore = useCreateEditCategoryFormStore()
const generateSlugSyncMode = ref<boolean>(false)

const {value: name} = useField<string|null>('name')
const {value: slug, setValue} = useField<string|null>('slug')

watch(generateSlugSyncMode, newV => {
    if (newV) {
        handleSyncNameAndSlug()
    }
})
const handleSyncNameAndSlug = async () => {
    if (!generateSlugSyncMode.value) {
        return
    }

    if (!name.value) {
        return
    }

    const slug = await slugify(name.value)

    setValue(slug)
}
</script>

<template>
    <div class="item-edit product-edit">
        <RowCheckbox name="is_active" label="Активность" />

        <RowSelect name="parent_id" label="Родительский раздел" :options="createEditCategoryFormStore.parentCategoryOptions" />

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="name" class="fw-bold">Название:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="name"
                >
                    <div :class="['input-group', !meta.valid && meta.touched ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
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
                    <div :class="['input-group', !meta.valid && meta.touched ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
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

        <RowInput name="ordering" label="Сортировка" type="number" />

        <DescriptionField />
    </div>
</template>
