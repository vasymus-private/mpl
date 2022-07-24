<script lang="ts" setup>
import {useFieldArray, Field} from "vee-validate"
import RowInput from "@/admin/inertia/components/forms/vee-validate/RowInput.vue"
import RowSelect from "@/admin/inertia/components/forms/vee-validate/RowSelect.vue"
import {useCharTypesStore} from "@/admin/inertia/modules/charTypes";
import {computed} from "vue";
import Option from "@/admin/inertia/modules/common/Option";


const charTypesStore = useCharTypesStore()
const {fields: charCategoriesFields, push: charCategoriesPush, remove: charCategoriesRemove, swap: charCategoriesSwap} = useFieldArray<{uuid: string, name: string}>('charCategories')
const {fields: charsFields, push: charsPush, remove: charsRemove, swap: charsSwap} = useFieldArray<{uuid: string, name: string, is_rate: boolean}>('chars')
const onRemoveCharCategory = (idx) => {
    if(confirm('Удалить заголовок и все его характеристики?')) {
        charCategoriesRemove(idx)
    }
}
const isCategoryChar = (charCategoryField, charField): boolean => {
    return charCategoryField.value.uuid === charField.value.category_uuid
}
 const chartCategoriesOptions = computed<Array<Option>>(() => {
     return charCategoriesFields.value.map(charCategoryField => ({value: charCategoryField.value.uuid, label: charCategoryField.value.name}))
 })
</script>

<template>
    <div class="item-edit product-edit">
        <div v-for="(charCategoryField, idx) in charCategoriesFields" :key="charCategoryField.value.uuid" class="mb-5 characteristics">
            <div class="row-line title-row-bg">
                <div class="buttons-block">
                    <button
                        :disabled="charCategoryField.isFirst"
                        @click="charCategoriesSwap(idx, idx - 1)"
                        class="btn btn__default"
                    >&uarr;</button>
                    <button
                        :disabled="charCategoryField.isLast"
                        @click="charCategoriesSwap(idx, idx + 1)"
                        class="btn btn__default"
                    >&darr;</button>
                </div>
                <Field
                    v-slot="{field, meta}"
                    :name="`charCategories[${idx}].name`"
                >
                    <input
                        v-bind="field"
                        :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
                        type="text"
                        :id="`charCategories[${idx}].name`"
                    />
                </Field>
<!--                <h4 class="title">{{charCategoryField.value.name}}</h4>-->
                <button
                    @click="onRemoveCharCategory(idx)"
                    type="button"
                    class="btn btn__remove"
                >x</button>
            </div>
            <template v-for="(charField, idx) in charsFields" :key="charField.value.uuid">
                <div  v-if="isCategoryChar(charCategoryField, charField)" class="row-line">
                    <div class="column">
                        <div class="buttons-block">
                            <button
                                :disabled="charField.isFirst"
                                type="button"
                                class="btn btn__default"
                                @click="charsSwap(idx, idx - 1)"
                            >&uarr;</button>
                            <button
                                :disabled="charField.isLast"
                                type="button"
                                class="btn btn__default"
                                @click="charsSwap(idx, idx + 1)"
                            >&darr;</button>
                        </div>
                        <label :for="`chars[${idx}].value`">{{charField.value.name}}:</label>
                    </div>
                    <div class="column between">
                        <Field
                            v-if="charField.value.is_rate"
                            v-slot="{field, meta}"
                            :name="`chars[${idx}].value`"
                        >
                            <select
                                :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '' ]"
                                :id="`chars[${idx}].value`"
                                v-bind="field"
                            >
                                <option value="">(не установлено)</option>
                                <option v-for="num in [...Array(6).keys()]" :key="num" :value="num">{{num}}</option>
                            </select>
                        </Field>
                        <Field
                            v-else
                            v-slot="{field, meta}"
                            :name="`chars[${idx}].value`"
                        >
                            <input
                                v-bind="field"
                                :class="['form-control', !meta.valid && meta.touched ? 'is-invalid' : '']"
                                type="text"
                                :id="`chars[${idx}].value`"
                            />
                        </Field>
                        <button
                            type="button"
                            class="btn btn__remove"
                            @click="charsRemove(idx)"
                        >x</button>
                    </div>
                </div>
            </template>
        </div>

        <div class="row-buttons">
            <RowInput name="tempCharCategoryName" label="Название" />
            <div class="row mb-3">
                <div class="col-sm-7 offset-sm-5">
                    <button
                        type="button"
                        class="btn btn__add"
                    >Добавить заголовок</button>
                </div>
            </div>
        </div>
        <div class="row-buttons">
            <RowSelect name="tempChar.category_uuid" label="Категория" :options="chartCategoriesOptions" />
            <RowInput name="tempChar.name" label="Название" />
            <RowSelect name="tempChar.type_id" label="Категория" :options="charTypesStore.options" />
            <div class="row mb-3">
                <div class="col-sm-7 offset-sm-5">
                    <button
                        type="button"
                        class="btn btn__add"
                    >Добавить характеристику</button>
                </div>
            </div>
        </div>
    </div>
</template>
