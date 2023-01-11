import { defineStore } from "pinia"
import {
    ContactFormItem,
    ContactForm,
} from "@/admin/inertia/modules/contactForms/types"
import {
    ErrorResponse,
    Links,
    Meta,
    Option,
} from "@/admin/inertia/modules/common/types"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import {
    errorsToErrorFields,
    extendMetaLinksWithComputedData,
} from "@/admin/inertia/modules/common"
import axios, { AxiosError } from "axios"
import {DateTime} from "luxon";

export const storeName = "contactForms"
const format = "yyyy-LL-dd HH:mm:ss"

interface State {
    _entities: Array<ContactFormItem>
    _entity: ContactForm | null
    _links: Links | null
    _meta: Meta | null
}

export const useContactFormsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _entities: [],
            _entity: null,
            _links: null,
            _meta: null,
        }
    },
    getters: {
        contactFormList: (state: State): Array<ContactFormItem> =>
            state._entities,
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
        contactForm: (state: State): ContactForm | null => state._entity,
        contactFormIds() {
            return (uuids: Array<string>): Array<number> => {
                let list = this.contactFormList
                    .filter((item) => uuids.includes(item.uuid))
                    .map((item) => item.id)
                if (uuids.includes(this._entity?.uuid)) {
                    list = [...list, this._entity.id]
                }

                return list
            }
        },
    },
    actions: {
        setEntities(entities: Array<ContactFormItem>): void {
            this._entities = entities
        },
        setLinks(links: Links | null): void {
            this._links = links
        },
        setMeta(meta: Meta | null): void {
            const routesStore = useRoutesStore()
            this._meta = meta
                ? extendMetaLinksWithComputedData(meta, routesStore.fullUrl)
                : null
        },
        setEntity(entity: ContactForm | null): void {
            if (!entity) {
                this._entity = entity
                return
            }
            this._entity = {
                ...entity,
                dt_created_at: entity.created_at
                    ? DateTime.fromFormat(entity.created_at, format)
                    : null,
            }
        },
        removeEntities(uuids: Array<string>): void {
            this._entities = this._entities.filter(
                (item) => !uuids.includes(item.uuid)
            )
        },
        async deleteBulkContactFormItems(
            checkedItemsUuids: Array<string>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedItemsUuids.length) {
                return
            }

            const routesStore = useRoutesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_CONTACT_FORMS_BULK_DELETE
                    )
                )
                const checkedContactFormItemsIds =
                    this.contactFormIds(checkedItemsUuids)
                checkedContactFormItemsIds.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                this.removeEntities(checkedItemsUuids)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    return errorsToErrorFields(errors)
                }
                throw e
            }
        },
    },
})
