<script lang="ts" setup>
import {Field, useFieldArray} from "vee-validate"


const { remove, push, fields } = useFieldArray('infoPrices')
</script>

<template>
    <div class="row mb-3">
        <div class="col-sm-5 text-end">
            <label>Информационные цены:</label>
        </div>
        <div class="col-sm-7">
            <div
                v-for="(field, idx) in fields"
                :key="field.key"
                class="row mb-2"
            >
                <div class="col-sm-3">
                    <Field
                        v-slot="{field, meta}"
                        :name="`infoPrices[${idx}].price`"
                    >
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid ? 'is-invalid' : '']"
                            type="number"
                            placeholder="Цена"
                        />
                    </Field>
                </div>
                <div class="col-sm-7">
                    <Field
                        v-slot="{field, meta}"
                        :name="`infoPrices[${idx}].name`"
                    >
                        <input
                            v-bind="field"
                            :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
                            type="text"
                            placeholder="Описание"
                        />
                    </Field>
                </div>
                <div class="col-sm-2">
                    <button
                        @click="remove(idx)"
                        type="button"
                        class="btn btn-outline-danger btn__remove"
                    >x</button>
                </div>
            </div>
            <button
                @click="push({id: null, name: null, price: null})"
                type="button"
                class="btn btn__default"
            >Добавить</button>
        </div>
    </div>
</template>
