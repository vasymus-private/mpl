<script lang="ts" setup>
import {itemsWithImageUpload, itemsWithoutImageUpload} from '@/vendor/ckeditor5/src/defaultConfig'
import {getXsrfToken} from '@/admin/inertia/utils'
import {computed} from "vue"


const props = defineProps<{
    modelValue?: string|null
    uploadUrl?: string|null
}>()
const emits = defineEmits(['update:modelValue'])
const input = (value) => {
    emits('update:modelValue', value)
}

let configWithUpload = computed(() => {
    return {
        toolbar: {
            items: itemsWithImageUpload
        },
        simpleUpload: {
            uploadUrl: props.uploadUrl,
            withCredentials: true,
            headers: {
                'X-XSRF-TOKEN': getXsrfToken(),
            }
        },
    }
})
let configWithoutUpload: {toolbar: object, simpleUpload: object} = {
    toolbar: {
        items: itemsWithoutImageUpload
    },
    simpleUpload: {
        uploadUrl: 'https://example.com',
    },
}
let editor = require('ckeditor5-custom-build')
let { component } = require('@ckeditor/ckeditor5-vue')
let CKEditor = component
</script>

<template>
    <div v-if="CKEditor && editor" class="app-html-editor">
        <div v-if="props.uploadUrl">
            <CKEditor
                :editor="editor"
                :config="configWithUpload"
                :model-value="props.modelValue || ''"
                @input="input"
            />
        </div>
        <div v-show="!props.uploadUrl">
            <CKEditor
                :editor="editor"
                :config="configWithoutUpload"
                :model-value="props.modelValue || ''"
                @input="input"
            />
        </div>
    </div>
</template>
