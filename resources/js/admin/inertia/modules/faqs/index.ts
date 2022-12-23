import { Faq, FaqListItem } from "@/admin/inertia/modules/faqs/types"
import {
    ErrorResponse,
    Links,
    Meta,
    Option,
} from "@/admin/inertia/modules/common/types"
import { defineStore } from "pinia"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import {
    errorsToErrorFields,
    extendMetaLinksWithComputedData,
} from "@/admin/inertia/modules/common"
import axios, { AxiosError } from "axios"
import { arrayToMap } from "@/admin/inertia/utils"

export const storeName = "faqs"

interface State {
    _entities: Array<FaqListItem>
    _entity: Faq | null
    _links: Links | null
    _meta: Meta | null
    _options: Array<Option>
}

export const useFaqsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _entities: [],
            _entity: null,
            _links: null,
            _meta: null,
            _options: [],
        }
    },
    getters: {
        faqsList: (state: State): Array<FaqListItem> => state._entities,
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
        faq: (state: State): Faq | null => state._entity,
        options: (state: State): Array<Option> => state._options,
        isCreatingFaqRoute(): boolean {
            let routesStore = useRoutesStore()

            return [routeNames.ROUTE_ADMIN_FAQ_CREATE].includes(
                routesStore.current
            )
        },
        faqIds() {
            return (uuids: Array<string>): Array<number> => {
                return this.faqsList
                    .filter((item) => uuids.includes(item.uuid))
                    .map((item) => item.id)
            }
        },
    },
    actions: {
        setEntities(entities: Array<FaqListItem>): void {
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
        setEntity(entity: Faq | null): void {
            this._entity = entity
        },
        setOptions(options: Array<Option>): void {
            this._options = options
        },
        removeEntities(uuids: Array<string>): void {
            this._entities = this._entities.filter(
                (item) => !uuids.includes(item.uuid)
            )
        },
        addOrUpdateFaqsListItems(listItems: Array<FaqListItem>): void {
            let newItemById = arrayToMap<FaqListItem>(listItems)

            this._entities = this._entities.map((item: FaqListItem) => {
                let newListItem = newItemById[item.id]

                if (newListItem) {
                    listItems = listItems.filter((it) => it.id !== item.id)
                    return newListItem
                }

                return item
            })

            this._entities = [...this._entities, ...listItems]
        },
        async deleteBulkFaqs(
            checkedFaqsUuids: Array<string>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedFaqsUuids.length) {
                return
            }

            const routesStore = useRoutesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_FAQ_BULK_DELETE
                    )
                )
                const checkedFaqIds = this.faqIds(checkedFaqsUuids)
                checkedFaqIds.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                this.removeEntities(checkedFaqsUuids)
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
