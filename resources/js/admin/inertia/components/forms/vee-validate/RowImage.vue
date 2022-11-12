<script setup lang="ts">
import {useField} from "vee-validate"
import {randomId} from "@/admin/inertia/utils"
import {toRef, ref} from 'vue'
import { useDropZone } from '@vueuse/core'
import {Media} from "@/admin/inertia/modules/common/types"


const props = defineProps<{
    name: string
    label: string
    keepValue?: boolean
}>()

const name = toRef(props, 'name')
const {value, setValue, meta} = useField<Partial<Media>>(name, undefined, {keepValueOnUnmount: props.keepValue})
const dropZoneRef = ref<HTMLDivElement>(null)
const inputFileRef = ref<HTMLInputElement>(null)

const save = (files: File[] | null) => {
    if (!files) {
        return
    }

    [...files].forEach(file => {
        setValue({
            id: null,
            uuid: randomId(),
            name: file.name,
            file_name: file.name,
            url: URL.createObjectURL(file),
            file
        })
    })
}
const onImageChange = event => {
    save(event.target.files)
}
const { isOverDropZone } = useDropZone(dropZoneRef, save)
</script>

<template>
    <div class="row">
        <div class="col-sm-6 d-flex align-items-center">
            <label
                :for="name"
                class="w-100 text-end"
                style="cursor: pointer"
            >{{ props.label }}:</label>
        </div>
        <div class="col-sm-6">
            <div
                class="add-file d-flex justify-content-center"
                :style="isOverDropZone ? {borderStyle: 'solid'} : {}"
                @click="inputFileRef.click()"
                ref="dropZoneRef"
            >
                <div v-if="value" @click.stop="" class="card text-center">
                    <a :href="value.url" target="_blank"><img class="img-thumbnail" :src="value.url" alt=""></a>
                    <div class="form-group">
                        <input
                            v-model="value.name"
                            :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                            type="text"
                            placeholder="Имя файла"
                        />
                    </div>
                    <button type="button" @click.stop="setValue(null)" class="adm-fileinput-item-preview__remove">x</button>
                </div>
                <input
                    v-show="false"
                    ref="inputFileRef"
                    @change="onImageChange"
                    type="file"
                    class="form-control-file"
                    :id="name"
                />
            </div>
        </div>
    </div>
</template>
