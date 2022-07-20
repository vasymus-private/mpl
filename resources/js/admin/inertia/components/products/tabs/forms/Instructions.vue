<script lang="ts" setup>
import {Field, useFieldArray} from "vee-validate"
import {ref} from 'vue'
import {useFormsStore} from "@/admin/inertia/modules/forms"


const { remove, push, swap, fields } = useFieldArray('instructions')
const files = ref([])
const formsStore = useFormsStore()

const onChange = (event) => {
    event.target.files.forEach(file => {
        const maxColumn = formsStore.maxInstructionsColumn
        push({
            id: null,
            name: file.name,
            file_name: file.name,
            url: URL.createObjectURL(file),
            order_column: maxColumn ? maxColumn + 100 : 100,
            file,
        })
    })
}
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label for="name" class="fw-bold">Дополнительные файлы (инструкции):</label>
        </div>
        <div class="col-sm-7">
            <div class="add-file">
                <div class="row">
                    <div v-for="(field, idx) in fields" class="card text-center">
                        <div class="adm-fileinput-item-preview">
                            <h5 class="card-title"><a :href="field.value.url" target="_blank">{{field.value.file_name}}</a></h5>
                        </div>
                        <div class="form-group">
                            <Field
                                v-slot="{field, meta}"
                                :name="`instructions[${idx}].name`"
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
                    <div>
                        <span class="add-file__text">Перетащите файлы в эту область (Drag&Drop)</span>
                        <input
                            type="file"
                            @change="onChange"
                            multiple
                            class="form-control-file"
                            id="tempInstructions"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
