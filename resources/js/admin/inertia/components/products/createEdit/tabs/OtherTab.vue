<script lang="ts" setup>
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import {Field} from "vee-validate"


const categoriesStore = useCategoriesStore()
</script>

<template>
    <div class="item-edit product-edit other-page">
        <div class="row-line">
            <div class="column">
                <span class="other-page__title">Разделы:</span>
            </div>
            <div class="column">
                <template v-for="category in categoriesStore.categories" :key="category.id">
                    <div class="other-page__item">
                        <div class="form-check form-check-inline">
                            <Field
                                name="category_id"
                                type="radio"
                                class="form-check-input radio"
                                :value="category.id"
                            />
                            <label class="custom-checkbox">
                                <Field
                                    name="relatedCategoriesIds"
                                    class="form-check-input"
                                    type="checkbox"
                                    :value="category.id"
                                />
                                <span class="label">
                                    {{ category.name }}
                                </span>
                            </label>
                        </div>
                    </div>
                    <template v-for="subcategory1 in category.subcategories" :key="subcategory1.id">
                        <div class="other-page__item">
                            <div class="form-check form-check-inline">
                                <Field
                                    name="category_id"
                                    type="radio"
                                    class="form-check-input radio"
                                    :value="subcategory1.id"
                                />
                                <label class="custom-checkbox">
                                    <Field
                                        name="relatedCategoriesIds"
                                        class="form-check-input"
                                        type="checkbox"
                                        :value="subcategory1.id"
                                    />
                                    <span class="label">
                                        <span>.</span>
                                        {{ subcategory1.name }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        <template v-for="subcategory2 in subcategory1.subcategories" :key="subcategory2.id">
                            <div class="other-page__item">
                                <div class="form-check form-check-inline">
                                    <Field
                                        name="category_id"
                                        type="radio"
                                        class="form-check-input radio"
                                        :value="subcategory2.id"
                                    />
                                    <label class="custom-checkbox">
                                        <Field
                                            name="relatedCategoriesIds"
                                            class="form-check-input"
                                            type="checkbox"
                                            :value="subcategory2.id"
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
        </div>
    </div>
</template>
