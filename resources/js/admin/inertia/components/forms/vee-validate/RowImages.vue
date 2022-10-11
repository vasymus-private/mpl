<script setup lang="ts">
import {Field, useFieldArray} from "vee-validate"
import {Media} from "@/admin/inertia/modules/common/types"
import {ref, toRef} from "vue"
import {maxBy} from "lodash"
import {randomId} from "@/admin/inertia/utils"
import { useDropZone } from '@vueuse/core'


const props = defineProps<{
    name: string
    label: string
    keepValue?: boolean
}>()

const name = toRef(props, 'name')
const {fields, push, remove, swap} = useFieldArray<Media>(name)
const inputFileRef = ref<HTMLInputElement>(null)
const dropZoneRef = ref<HTMLDivElement>(null)

const save = (files: File[] | null) => {
    if (!files) {
        return
    }

    files.forEach(file => {
        const max = maxBy(
            fields.value,
            (item) => item.value.order_column
        )

        const maxColumn =  (max && max.value.order_column) || undefined
        push({
            id: null,
            uuid: randomId(),
            name: file.name,
            file_name: file.name,
            url: URL.createObjectURL(file),
            order_column: maxColumn ? maxColumn + 100 : 100,
            file,
        })
    })
}
const onChange = (event) => {
    save(event.target.files)
}
const { isOverDropZone } = useDropZone(dropZoneRef, save)
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-6 d-flex align-items-center">
            <label
                :for="name"
                class="w-100 text-end"
                style="cursor: pointer"
            >{{ props.label }}:</label>
        </div>
        <div class="col-sm-6">
            <div
                class="add-file d-flex justify-content-center flex-wrap"
                :style="isOverDropZone ? {borderStyle: 'solid'} : {}"
                @click="inputFileRef.click()"
                ref="dropZoneRef"
            >
                <div v-for="(field, idx) in fields" @click.stop="" class="card text-center">
                    <a :href="field.value.url" target="_blank">
                        <img class="img-thumbnail" :src="field.value.url" alt="" />
                    </a>
                    <div class="form-group">
                        <Field
                            v-slot="{field, meta}"
                            :name="`${name}[${idx}].name`"
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
                    type="file"
                    ref="inputFileRef"
                    multiple
                    @change="onChange"
                    class="form-control-file"
                    :id="name"
                />
            </div>
        </div>
    </div>
</template>
