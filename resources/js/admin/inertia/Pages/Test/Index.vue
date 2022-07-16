<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import { Head } from '@inertiajs/inertia-vue3'
import { useForm } from 'vee-validate'
import FormGroupCheckBox from '@/admin/inertia/components/forms/vee-validate/FormGroupCheckBox.vue'
import FormGroupInput from '@/admin/inertia/components/forms/vee-validate/FormGroupInput.vue'
import * as yup from "yup"


const {errors, handleSubmit} = useForm({
    validationSchema: yup.object({
        is_active: yup.boolean().required().oneOf([true], 'Field must be checked'),
        ordering: yup.number().integer(),
    }),
    initialValues: {
        is_active: false,
        ordering: 500
    }
})

const onSubmit = handleSubmit(
    (values, actions) => {
        console.log('--- values', values)
        console.log('--- actions', actions)
    },
    ({values, errors, results}) => {
        console.log(values, errors, results)
    }
)
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Test" />
            <form @submit="onSubmit">
                <FormGroupCheckBox name="is_active" label="Активность" id="is_active" />
                <FormGroupInput name="ordering" label="Сортировка" />

                <button type="submit">Сохранить</button>
            </form>
        </div>
    </TheLayout>
</template>
