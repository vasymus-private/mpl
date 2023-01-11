<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {Inertia} from "@inertiajs/inertia"
import {useToastsStore} from "@/admin/inertia/modules/toasts"
import {useContactFormsStore} from "@/admin/inertia/modules/contactForms"


const routesStore = useRoutesStore()
const toastsStore = useToastsStore()
const contactFormsStore = useContactFormsStore()

const handleDelete = async () => {
    if (!contactFormsStore.contactForm?.id) {
        return
    }

    if (confirm(`Вы уверены, что хотите удалить контактную форму?`)) {
        let errorsOrVoid = await contactFormsStore.deleteBulkContactFormItems([contactFormsStore.contactForm.uuid])
        if (!errorsOrVoid) {
            Inertia.visit(
                routesStore.route(
                    routeNames.ROUTE_ADMIN_CONTACT_FORMS_INDEX
                )
            )
            return
        }

        for (let key in errorsOrVoid) {
            toastsStore.error({
                title: key,
                message: errorsOrVoid[key]
            })
        }
    }
}
</script>

<template>
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <Link :href="routesStore.route(routeNames.ROUTE_ADMIN_CONTACT_FORMS_INDEX)" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Контактные формы</span>
                    <span class="detail-toolbar__btn-r"></span>
                </Link>
            </div>
            <div class="col-sm-5 d-flex align-items-center">
                <button type="button" @click="handleDelete" class="btn btn-danger mx-1">Удалить</button>
            </div>
        </div>
    </div>
</template>
