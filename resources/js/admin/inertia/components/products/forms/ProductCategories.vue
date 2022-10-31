<script setup lang="ts">
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {Field} from "vee-validate"


const props = defineProps<{
    namePrefix?: string|null
}>()
const categoriesStore = useCategoriesStore()
</script>

<template>
    <div class="column">
        <template v-for="category in categoriesStore.categories" :key="`category-${category.id}`">
            <div class="other-page__item">
                <div class="form-check form-check-inline">
                    <Field
                        :name="`${props.namePrefix || ''}category_id`"
                        type="radio"
                        class="form-check-input radio"
                        :value="category.id"
                        :keep-value="true"
                    />
                    <label class="custom-checkbox">
                        <Field
                            :name="`${props.namePrefix || ''}relatedCategoriesIds`"
                            class="form-check-input"
                            type="checkbox"
                            :value="category.id"
                            :keep-value="true"
                        />
                        <span class="label">
                            {{ category.name }}
                        </span>
                    </label>
                </div>
            </div>
            <template v-for="subcategory1 in category.subcategories" :key="`subcategory-1-${subcategory1.id}`">
                <div class="other-page__item">
                    <div class="form-check form-check-inline">
                        <Field
                            :name="`${props.namePrefix || ''}category_id`"
                            type="radio"
                            class="form-check-input radio"
                            :value="subcategory1.id"
                            :keep-value="true"
                        />
                        <label class="custom-checkbox">
                            <Field
                                :name="`${props.namePrefix || ''}relatedCategoriesIds`"
                                class="form-check-input"
                                type="checkbox"
                                :value="subcategory1.id"
                                :keep-value="true"
                            />
                            <span class="label">
                                <span>.</span>
                                {{ subcategory1.name }}
                            </span>
                        </label>
                    </div>
                </div>
                <template v-for="subcategory2 in subcategory1.subcategories" :key="`subcategory-2-${subcategory2.id}`">
                    <div class="other-page__item">
                        <div class="form-check form-check-inline">
                            <Field
                                :name="`${props.namePrefix || ''}category_id`"
                                type="radio"
                                class="form-check-input radio"
                                :value="subcategory2.id"
                                :keep-value="true"
                            />
                            <label class="custom-checkbox">
                                <Field
                                    :name="`${props.namePrefix || ''}relatedCategoriesIds`"
                                    class="form-check-input"
                                    type="checkbox"
                                    :value="subcategory2.id"
                                    :keep-value="true"
                                />
                                <span class="label">
                                    <span>.</span>
                                    <span>.</span>
                                    {{ subcategory2.name }}
                                </span>
                            </label>
                        </div>
                    </div>
                </template>
            </template>
        </template>
    </div>
</template>
