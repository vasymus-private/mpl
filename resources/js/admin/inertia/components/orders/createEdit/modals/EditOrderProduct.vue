<script lang="ts" setup>
import Modal from '@/admin/inertia/components/modals/Modal.vue'
import {ModalType} from "@/admin/inertia/modules/modals/types"
import {useFieldArray} from "vee-validate"
import {OrderProductItem} from "@/admin/inertia/modules/orders/types"
import {useModalsStore} from "@/admin/inertia/modules/modals"
import RowInput from "@/admin/inertia/components/forms/vee-validate/RowInput.vue"
import {computed} from "vue"


const props = defineProps<{
    type: ModalType
    modalProps: {
        index: number
    }
}>()

const modalsStore = useModalsStore()

const {fields, update} = useFieldArray<OrderProductItem>('products')

const field = computed<OrderProductItem>(() => fields.value[props.modalProps.index].value)
const initialName: string = field.value.order_product_name
const initialUnit: string = field.value.order_product_unit
const initialPriceRetailRub: number = field.value.order_product_price_retail_rub
const initialCount: number = field.value.order_product_count

const save = () => {
    if (Math.floor(field.value.order_product_price_retail_rub * 1000) !== Math.floor(initialPriceRetailRub * 1000)) {
        update(props.modalProps.index, {
            ...field.value,
            order_product_price_retail_rub_was_updated: true,
        })
    }
    modalsStore.closeModal(props.type)
}
const cancel = () => {
    update(props.modalProps.index, {
        ...field.value,
        order_product_name: initialName,
        order_product_unit: initialUnit,
        order_product_price_retail_rub: initialPriceRetailRub,
        order_product_count: initialCount,
    })
    modalsStore.closeModal(props.type)
}
</script>
<template>
    <Modal :type="props.type" title="Редактирование товара">
        <template #default>
            <div>
                <RowInput
                    :name="`products[${props.modalProps.index}].order_product_name`"
                    label="Наименование"
                    :keep-value="true"
                />

                <RowInput
                    :name="`products[${props.modalProps.index}].order_product_unit`"
                    label="Упаковка / Единица"
                    :keep-value="true"
                />

                <RowInput
                    :name="`products[${props.modalProps.index}].order_product_price_retail_rub`"
                    label="Розничная цена (руб)"
                    :keep-value="true"
                />

                <RowInput
                    :name="`products[${props.modalProps.index}].order_product_count`"
                    label="Количество"
                    :keep-value="true"
                />
            </div>
        </template>

        <template #footer>
            <button @click="save" type="button" class="btn btn-primary">Сохранить</button>
            <button @click="cancel" type="button" class="btn btn-secondary">Закрыть</button>
        </template>
    </Modal>
</template>
