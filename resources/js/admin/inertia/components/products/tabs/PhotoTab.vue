<script lang="ts" setup>
import {useFieldArray, Field} from 'vee-validate'
import {ref} from 'vue'
import RowImage from '@/admin/inertia/components/forms/vee-validate/RowImage.vue'
import Image from "@/admin/inertia/modules/common/Image"
import {maxBy} from "lodash"
import {randomId} from "@/admin/inertia/utils"


const {fields, push, remove, swap} = useFieldArray<Image>('additionalImages')
const additionalImagesRef = ref(null)
const onAdditionalImagesChange = event => {
    event.target.files.forEach(file => {
        const max = maxBy(
            fields.value,
            (item) => item.value.order_column
        )

        const maxColumn = (max && max.value.order_column) || undefined
        push({
            id: null,
            uuid: randomId(),
            name: file.name,
            file_name: file.name,
            url: URL.createObjectURL(file),
            order_column: maxColumn ? maxColumn + 100 : 100,
            file
        })
    })
}
</script>

<template>
    <div class="item-edit product-edit">
        <RowImage name="mainImage" label="Основное фото" />

        <div class="row">
            <div class="col-sm-6 d-flex align-items-center">
                <label class="w-100 text-end" style="cursor: pointer" for="additionalImages">Дополнительные фото:</label>
            </div>
            <div class="col-sm-6">
                <div class="add-file d-flex justify-content-center flex-wrap" @click="additionalImagesRef.click()">
                    <div v-for="(field, idx) in fields" @click.stop="" class="card text-center">
                        <a :href="field.value.url" target="_blank"><img class="img-thumbnail" :src="field.value.url" alt=""></a>
                        <div class="form-group">
                            <Field
                                v-slot="{field, meta}"
                                :name="`additionalImages[${idx}].name`"
                            >
                                <input
                                    v-bind="field"
                                    :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                                    type="text"
                                    placeholder="Имя файла"
                                />
                            </Field>
                        </div>
                        <button
                            :disabled="field.isFirst"
                            type="button"
                            class="btn btn__default"
                            @click="swap(idx, idx - 1)"
                        >&uarr;</button>
                        <button
                            type="button"
                            class="adm-fileinput-item-preview__remove"
                            @click="remove(idx)"
                        >&nbsp;</button>
                        <button
                            :disabled="field.isLast"
                            type="button"
                            class="btn btn__default"
                            @click="swap(idx, idx + 1)"
                        >&darr;</button>
                    </div>
                    <input
                        v-show="false"
                        ref="additionalImagesRef"
                        multiple
                        @change="onAdditionalImagesChange"
                        type="file"
                        class="form-control-file"
                        id="additionalImages"
                        name="additionalImages"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
