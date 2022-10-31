<script setup lang="ts">
import {Field, useField} from 'vee-validate'
import {computed, toRef, defineAsyncComponent} from "vue"
import {useMounted} from "@vueuse/core"


const isMounted = useMounted()
const AppHtmlEditor = defineAsyncComponent(() => import('@/admin/inertia/components/forms/parts/AppHtmlEditor.vue'))

const props = defineProps<{
    id: string
    label: string
    name: string
    uploadUrl?: string|null
}>()
const name = toRef(props, 'name')
const {setValue, value: _value} = useField<string|null>(name)

const value = computed({
    get() {
        return _value.value || null
    },
    set(nv) {
        return setValue(nv)
    }
})
</script>

<template>
    <div>
        <div class="h2">{{ props.label }}</div>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    :id="`${props.id}-html-tab`"
                    data-bs-toggle="tab"
                    :data-bs-target="`#${props.id}-html`"
                    type="button"
                    role="tab"
                    :aria-controls="`${props.id}-html`"
                    aria-selected="false"
                >HTML</button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    :id="`${props.id}-editor-tab`"
                    data-bs-toggle="tab"
                    :data-bs-target="`#${props.id}-editor`"
                    type="button"
                    role="tab"
                    :aria-controls="`${props.id}-editor`"
                    aria-selected="true"
                >Визуальный редактор</button>
            </li>
        </ul>

        <div class="tab-content" :id="`nav-${props.id}-tab-content`">
            <div
                class="tab-pane fade"
                style="height: 600px"
                :id="`${props.id}-html`"
                role="tabpanel"
                :aria-labelledby="`${props.id}-html-tab`"
            >
                <Field
                    v-slot="{field, meta}"
                    :name="name"
                >
                    <textarea
                        v-bind="field"
                        :class="['form-control', 'h-100', !meta.valid ? 'is-invalid' : '']"
                        :id="props.id"
                        rows="3"
                    />
                </Field>
            </div>
            <div
                class="tab-pane fade show active"
                :id="`${props.id}-editor`"
                role="tabpanel"
                :aria-labelledby="`${props.id}-editor-tab`"
            >
                <AppHtmlEditor
                    v-if="isMounted"
                    v-model="value"
                    :upload-url="props.uploadUrl"
                />
            </div>
        </div>
    </div>
</template>
