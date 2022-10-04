<script lang="ts" setup>
import {useFieldArray, Field, useField, useFieldValue} from "vee-validate"
import RowInput from "@/admin/inertia/components/forms/vee-validate/RowInput.vue"
import RowSelect from "@/admin/inertia/components/forms/vee-validate/RowSelect.vue"
import {useCharTypesStore} from "@/admin/inertia/modules/charTypes"
import {computed} from "vue"
import Option from "@/admin/inertia/modules/common/Option"
import {randomId} from "@/admin/inertia/utils"
import {CharTypeEnum} from "@/admin/inertia/modules/charTypes/CharType"
import {maxBy} from "lodash"
import {Char, CharCategory} from "@/admin/inertia/modules/products/Char"


const charTypesStore = useCharTypesStore()
const {
    fields: charCategoriesFields,
    push: charCategoriesPush,
    remove: charCategoriesRemove,
    swap: charCategoriesSwap
} = useFieldArray<Partial<CharCategory>>('charCategories')
const productId = useFieldValue<number|undefined>('id')
const {
    fields: charsFields,
    push: charsPush,
    remove: charsRemove,
    swap: charsSwap
} = useFieldArray<Partial<Char>>('chars')
const onRemoveCharCategory = (charCategoryField, idx) => {
    if(confirm('Удалить заголовок и все его характеристики?')) {
        charCategoriesRemove(idx)
        for (let i = 0; i < charsFields.value.length; i++) {
            if (!isCategoryChar(charCategoryField, charsFields.value[i])) {
                continue
            }

            charsRemove(i)
        }
    }
}
const isCategoryChar = (charCategoryField, charField): boolean => {
    return charCategoryField.value.uuid === charField.value.category_uuid
}
 const chartCategoriesOptions = computed<Array<Option>>(() => {
     return charCategoriesFields.value.map(charCategoryField => ({value: charCategoryField.value.uuid, label: charCategoryField.value.name}))
})

const {value: tempCharCategoryNameValue, setValue: tempCharCategoryNameSetValue} = useField<string>('tempCharCategoryName')
const {value: tempCharNameValue, setValue: tempCharNameSetValue} = useField<string>('tempChar.name')
const {value: tempCharTypeIdValue, setValue: tempCharTypeIdSetValue} = useField<number>('tempChar.type_id')
const {value: tempCharCategoryUuidValue, setValue: tempCharCategoryUuidSetValue} = useField<string>('tempChar.category_uuid')

const onAddCharCategory = () => {
    const max = maxBy(
        charCategoriesFields.value,
        (item) => item.value.ordering
    )

    const maxColumn = (max && max.value.ordering) || undefined
    charCategoriesPush({
        uuid: randomId(),
        name: tempCharCategoryNameValue.value,
        product_id: productId.value,
        ordering: maxColumn ? maxColumn + 100 : 100,
    })
    tempCharCategoryNameSetValue(null)
}
const onAddChar = () => {
    const max = maxBy(
        charsFields.value.filter(
            (item) => item.value.category_uuid === tempCharCategoryUuidValue.value
        ),
        (item) => item.value.ordering
    )

    const maxOrdering = (max && max.value.ordering) || undefined

    charsPush({
        name: tempCharNameValue.value,
        type_id: tempCharTypeIdValue.value,
        is_rate: tempCharTypeIdValue.value === CharTypeEnum.rate,
        uuid: randomId(),
        product_id: productId.value,
        category_uuid: tempCharCategoryUuidValue.value,
        ordering: maxOrdering ? maxOrdering + 100 : 100,
    })
    tempCharNameSetValue(null)
    tempCharTypeIdSetValue(null)
    tempCharCategoryUuidSetValue(null)
}
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
                <button
                    @click="onRemoveCharCategory(charCategoryField, idx)"
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
                        :disabled="!tempCharCategoryNameValue"
                        @click="onAddCharCategory"
                    >Добавить заголовок</button>
                </div>
            </div>
        </div>
        <div class="row-buttons">
            <RowSelect name="tempChar.category_uuid" label="Категория" :options="chartCategoriesOptions" />
            <RowInput name="tempChar.name" label="Название" />
            <RowSelect name="tempChar.type_id" label="Тип поля ввода" :options="charTypesStore.options" />
            <div class="row mb-3">
                <div class="col-sm-7 offset-sm-5">
                    <button
                        type="button"
                        class="btn btn__add"
                        :disabled="!tempCharNameValue || !tempCharTypeIdValue || !tempCharCategoryUuidValue"
                        @click="onAddChar"
                    >Добавить характеристику</button>
                </div>
            </div>
        </div>
    </div>
</template>
