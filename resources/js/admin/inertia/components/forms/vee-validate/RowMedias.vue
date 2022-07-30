<script lang="ts" setup>
import {Field, useFieldArray} from "vee-validate"
import {ref, toRef} from 'vue'
import {maxBy} from "lodash"
import Media from "@/admin/inertia/modules/common/Media"
import {randomId} from "@/admin/inertia/utils"
import { useDropZone } from '@vueuse/core'


const props = defineProps<{
    name: string
    label: string
    keepValue?: boolean
}>()

const name = toRef(props, 'name')
const {fields, remove, push, swap} = useFieldArray<Media>(name)
const dropZoneRef = ref<HTMLDivElement>(null)
const inputFileRef = ref<HTMLInputElement>(null)

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
        <div class="col-sm-5 text-end">
            <label
                :for="props.name"
                style="cursor: pointer"
                class="fw-bold"
            >{{ props.label }}:</label>
        </div>
        <div class="col-sm-7">
            <div
                class="add-file"
                :style="isOverDropZone ? {borderStyle: 'solid'} : {}"
                @click="inputFileRef.click()"
                ref="dropZoneRef"
            >
                <div class="row">
                    <div v-for="(field, idx) in fields" class="card text-center" @click.stop="">
                        <div class="adm-fileinput-item-preview">
                            <h5 class="card-title"><a :href="field.value.url" target="_blank">{{field.value.file_name}}</a></h5>
                        </div>
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
                </div>
                <div class="form-group">
                    <span class="add-file__text">Перетащите файлы в эту область (Drag&Drop)</span>
                    <input
                        v-show="false"
                        type="file"
                        ref="inputFileRef"
                        multiple
                        @change="onChange"
                        class="form-control-file"
                        :id="props.name"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
