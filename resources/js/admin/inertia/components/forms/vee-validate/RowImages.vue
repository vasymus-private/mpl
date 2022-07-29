<script setup lang="ts">
import {useFieldArray, Field} from "vee-validate"
import Image from "@/admin/inertia/modules/common/Image"
import {ref} from "vue"
import {maxBy} from "lodash"
import {randomId} from "@/admin/inertia/utils"


const props = defineProps<{
    name: string
    label: string
    keepValue?: boolean
}>()
const {fields, push, remove, swap} = useFieldArray<Image>(props.name)
const imagesRef = ref(null)
const onImagesChange = event => {
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
    <div class="row">
        <div class="col-sm-6 d-flex align-items-center">
            <label class="w-100 text-end" style="cursor: pointer" :for="props.name">{{ props.label }}:</label>
        </div>
        <div class="col-sm-6">
            <div class="add-file d-flex justify-content-center flex-wrap" @click="imagesRef.click()">
                <div v-for="(field, idx) in fields" @click.stop="" class="card text-center">
                    <a :href="field.value.url" target="_blank"><img class="img-thumbnail" :src="field.value.url" alt=""></a>
                    <div class="form-group">
                        <Field
                            v-slot="{field, meta}"
                            :name="`${props.name}[${idx}].name`"
                            :keep-value="props.keepValue"
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
                    ref="imagesRef"
                    multiple
                    @change="onImagesChange"
                    type="file"
                    class="form-control-file"
                    :id="props.name"
                />
            </div>
        </div>
    </div>
</template>
