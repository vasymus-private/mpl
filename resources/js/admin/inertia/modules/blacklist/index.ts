import {
    BlacklistItem,
    Blacklist,
} from "@/admin/inertia/modules/blacklist/types"
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

export const storeName = "blacklist"

interface State {
    _entities: Array<BlacklistItem>
    _entity: Blacklist | null
    _links: Links | null
    _meta: Meta | null
}

export const useBlacklistStore = defineStore(storeName, {
    state: (): State => {
        return {
            _entities: [],
            _entity: null,
            _links: null,
            _meta: null,
        }
    },
    getters: {
        blacklistItems: (state: State): Array<BlacklistItem> => state._entities,
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
        blacklist: (state: State): Blacklist | null => state._entity,
        isCreatingBlacklistRoute(): boolean {
            let routesStore = useRoutesStore()

            return [routeNames.ROUTE_ADMIN_BLACKLIST_CREATE].includes(
                routesStore.current
            )
        },
        blacklistIds() {
            return (uuids: Array<string>): Array<number> => {
                let list = this.blacklistItems
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
        setEntities(entities: Array<BlacklistItem>): void {
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
        setEntity(entity: Blacklist | null): void {
            this._entity = entity
        },
        removeEntities(uuids: Array<string>): void {
            this._entities = this._entities.filter(
                (item) => !uuids.includes(item.uuid)
            )
        },
        addOrUpdateBlacklistItems(listItems: Array<BlacklistItem>): void {
            let newItemById = arrayToMap<BlacklistItem>(listItems)

            this._entities = this._entities.map((item: BlacklistItem) => {
                let newListItem = newItemById[item.id]

                if (newListItem) {
                    listItems = listItems.filter((it) => it.id !== item.id)
                    return newListItem
                }

                return item
            })

            this._entities = [...this._entities, ...listItems]
        },
        async deleteBulkBlacklist(
            checkedBlacklistUuids: Array<string>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedBlacklistUuids.length) {
                return
            }

            const routesStore = useRoutesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_BLACKLIST_BULK_DELETE
                    )
                )
                const checkedBlacklistIds = this.blacklistIds(
                    checkedBlacklistUuids
                )
                checkedBlacklistIds.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                this.removeEntities(checkedBlacklistUuids)
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
