<script lang="ts" setup>
import NameAndSlug from '@/admin/inertia/components/forms/parts/NameAndSlug.vue'
import {useFaqsStore} from "@/admin/inertia/modules/faqs"
import RowSelect from '@/admin/inertia/components/forms/vee-validate/RowSelect.vue'
import RowCheckbox from '@/admin/inertia/components/forms/vee-validate/RowCheckbox.vue'

const faqsStore = useFaqsStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!faqsStore.isCreatingFaqRoute" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ faqsStore.faq?.id }}
            </div>
        </div>

        <RowCheckbox name="is_active" label="Активность" />

        <NameAndSlug />

        <RowSelect name="parent_id" label="Родительский вопрос-ответ" :options="faqsStore.optionsWithoutEntity" />
    </div>
</template>
