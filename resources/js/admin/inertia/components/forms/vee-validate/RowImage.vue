<script setup lang="ts">
import {useField} from "vee-validate"
import {ref} from "vue"
import {randomId} from "@/admin/inertia/utils"


const props = defineProps<{
    name: string
    label: string
}>()
const {value, setValue, meta} = useField(props.name)
const imageRef = ref(null)
const onImageChange = event => {
    event.target.files.forEach(file => {
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
</script>

<template>
    <div class="row">
        <div class="col-sm-6 d-flex align-items-center">
            <label
                class="w-100 text-end"
                style="cursor: pointer"
                :for="props.name"
            >{{ props.label }}:</label>
        </div>
        <div class="col-sm-6">
            <div class="add-file d-flex justify-content-center" @click="imageRef.click()">
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
                    ref="imageRef"
                    @change="onImageChange"
                    type="file"
                    class="form-control-file"
                    :id="props.name"
                    :name="props.name"
                />
            </div>
        </div>
    </div>
</template>
