import {Faq, FaqListItem} from "@/admin/inertia/modules/faq/types"
import {Links, Meta, Option} from "@/admin/inertia/modules/common/types"
import {defineStore} from "pinia"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {extendMetaLinksWithComputedData} from "@/admin/inertia/modules/common"

export const storeName = "faq"

interface State {
    _entities: Array<FaqListItem>
    _entity: Faq|null
    _links: Links | null
    _meta: Meta | null
    _options: Array<Option>
}

export const useFaqStore = defineStore(storeName, {
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
        faqList: (state: State): Array<FaqListItem> => state._entities,
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                    value: state._meta.per_page,
                    label: `${state._meta.per_page}`,
                }
                : null,
        faq: (state: State): Faq|null => state._entity,
        options: (state: State): Array<Option> => state._options,
        isCreatingFaqRoute(): boolean {
            let routesStore = useRoutesStore()

            return [
                routeNames.ROUTE_ADMIN_FAQ_CREATE,
            ].includes(routesStore.current)
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
    }
})
