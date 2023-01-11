<script lang="ts" setup>
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import Breadcrumbs from '@/admin/inertia/components/contactForms/show/parts/Breadcrumbs.vue'
import { Head } from '@inertiajs/inertia-vue3'
import Toolbar from "@/admin/inertia/components/contactForms/show/parts/Toolbar.vue"
import {useContactFormsStore} from "@/admin/inertia/modules/contactForms"
import IpDetails from '@/admin/inertia/components/parts/IpDetails.vue'
import {useRoutesStore, routeNames} from "@/admin/inertia/modules/routes"


const contactFormsStore = useContactFormsStore()
const routesStore = useRoutesStore()
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Контактная форма" />

            <Breadcrumbs />

            <h1 class="h2 adm-title">
                Справочники: контактные формы: просмотр
            </h1>

            <Toolbar />

            <div class="tab-content">
                <div class="tab-pane p-3 fade show active">
                    <div class="item-edit product-edit">
                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                ID:
                            </div>
                            <div class="col-sm-7">
                                {{ contactFormsStore.contactForm?.id }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                Тип:
                            </div>
                            <div class="col-sm-7">
                                {{ contactFormsStore.contactForm?.type_name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                IP:
                            </div>
                            <div class="col-sm-7">
                                <IpDetails v-if="contactFormsStore.contactForm?.ipDetails" :ip-details="contactFormsStore.contactForm?.ipDetails" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                Email:
                            </div>
                            <div class="col-sm-7">
                                {{ contactFormsStore.contactForm?.email }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                Имя:
                            </div>
                            <div class="col-sm-7">
                                {{ contactFormsStore.contactForm?.name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                Телефон:
                            </div>
                            <div class="col-sm-7">
                                {{ contactFormsStore.contactForm?.phone }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                Вопрос:
                            </div>
                            <div class="col-sm-7">
                                {{ contactFormsStore.contactForm?.description }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                Создано:
                            </div>
                            <div class="col-sm-7">
                                {{ contactFormsStore.contactForm?.dt_created_at ? contactFormsStore.contactForm?.dt_created_at.toFormat('dd.LL.yyyy HH:mm:ss') : null }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-end">
                                Прикрепленные файлы:
                            </div>
                            <div class="col-sm-7">
                                <p v-for="file in contactFormsStore.contactForm?.files" :key="file.uuid">
                                    <a target="_blank" download :href="routesStore.route(routeNames.ROUTE_ADMIN_MEDIA, {id: file.id, name: file.name})">{{file.name}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </TheLayout>
</template>
