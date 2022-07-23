<script lang="ts" setup>
import {useField, useFieldArray, Field} from 'vee-validate'
import {ref} from 'vue'
import {useFormsStore} from "@/admin/inertia/modules/forms"


const formsStore = useFormsStore()
const {value : mainImageValue, setValue : setMainImageValue, meta : mainImageMeta} = useField('mainImage')
const mainImageRef = ref(null)
const onMainImageChange = event => {
    event.target.files.forEach(file => {
        setMainImageValue({
            id: null,
            name: file.name,
            file_name: file.name,
            url: URL.createObjectURL(file),
            file
        })
    })
}

const {fields, push, remove, swap} = useFieldArray('additionalImages')
const additionalImagesRef = ref(null)
const onAdditionalImagesChange = event => {
    event.target.files.forEach(file => {
        const maxColumn = formsStore.maxAdditionalImagesColumn
        push({
            id: null,
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
        <div class="row">
            <div class="col-sm-6 d-flex align-items-center">
                <label class="w-100 text-end" style="cursor: pointer" for="mainImage">Основное фото:</label>
            </div>
            <div class="col-sm-6">
                <div class="add-file d-flex justify-content-center" @click="mainImageRef.click()">
                    <div v-if="mainImageValue" @click.stop="" class="card text-center">
                        <a :href="mainImageValue.url" target="_blank"><img class="img-thumbnail" :src="mainImageValue.url" alt=""></a>
                        <div class="form-group">
                            <input
                                v-model="mainImageValue.name"
                                :class="['form-control', !mainImageMeta.valid ? 'is-invalid' : '']"
                                type="text"
                                placeholder="Имя файла"
                            />
                        </div>
                        <button type="button" @click.stop="setMainImageValue(null)" class="adm-fileinput-item-preview__remove">x</button>
                    </div>
                    <input
                        v-show="false"
                        ref="mainImageRef"
                        @change="onMainImageChange"
                        type="file"
                        class="form-control-file"
                        id="mainImage"
                        name="mainImage"
                    />
                </div>
            </div>
        </div>

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
