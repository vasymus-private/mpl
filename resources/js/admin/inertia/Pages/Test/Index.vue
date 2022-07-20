<script lang="ts" setup>
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import { Head } from '@inertiajs/inertia-vue3'
import { useForm } from 'vee-validate'
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
                <button type="submit">Сохранить</button>
            </form>
        </div>
    </TheLayout>
</template>
