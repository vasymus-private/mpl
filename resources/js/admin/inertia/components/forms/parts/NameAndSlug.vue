<script setup lang="ts">
import useSyncNameAndSlug from "@/admin/inertia/composables/useSyncNameAndSlug"
import {useField, Field} from "vee-validate"


const {value: name} = useField<string|null>('name')
const {value: slug, setValue} = useField<string|null>('slug')
const {generateSlugSyncMode, watchGenerateSlugSyncMode, handleSyncNameAndSlug} = useSyncNameAndSlug(name, setValue)
watchGenerateSlugSyncMode()
</script>

<template>
    <div>
        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="name" class="fw-bold">Название:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="name"
                >
                    <div :class="['input-group', !meta.valid && meta.touched ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
                            type="text"
                            id="name"
                            @blur="handleSyncNameAndSlug"
                        />
                        <div class="input-group-append">
                            <button
                                @click="generateSlugSyncMode = !generateSlugSyncMode"
                                class="btn btn-outline-secondary"
                                type="button"
                            ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </Field>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                <label for="slug" class="fw-bold">Символьный код:</label>
            </div>
            <div class="col-sm-7">
                <Field
                    v-slot="{ field, meta }"
                    name="slug"
                >
                    <div :class="['input-group', !meta.valid && meta.touched ? 'has-validation' : '']">
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
                            type="text"
                            id="slug"
                        />
                        <div class="input-group-append">
                            <button
                                @click="generateSlugSyncMode = !generateSlugSyncMode"
                                class="btn btn-outline-secondary"
                                type="button"
                            ><i :class="['fa', generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken']" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </Field>
            </div>
        </div>
    </div>
</template>
