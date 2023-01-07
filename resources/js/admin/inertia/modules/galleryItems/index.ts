import { defineStore } from "pinia"
import {
    GalleryItem,
    GalleryItemListItem,
} from "@/admin/inertia/modules/galleryItems/types"
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
import { arrayToMap } from "@/admin/inertia/utils"
import axios, { AxiosError } from "axios"

export const storeName = "galleryItems"

interface State {
    _entities: Array<GalleryItemListItem>
    _entity: GalleryItem | null
    _links: Links | null
    _meta: Meta | null
    _options: Array<Option>
}

export const useGalleryItemsStore = defineStore(storeName, {
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
        galleryItemList: (state: State): Array<GalleryItemListItem> =>
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
        galleryItem: (state: State): GalleryItem | null => state._entity,
        options: (state: State): Array<Option> => state._options,
        optionsWithoutEntity: (state: State): Array<Option> =>
            state._options.filter(
                (option) => `${option.value}` !== `${state._entity?.id}`
            ),
        option() {
            return (galleryItemId: string | number): Option | null => {
                let option = this.options.find(
                    (o: Option) => `${o.value}` === `${galleryItemId}`
                )
                return option ? option : null
            }
        },
        isCreatingGalleryItemRoute(): boolean {
            let routesStore = useRoutesStore()

            return [routeNames.ROUTE_ADMIN_GALLERY_ITEMS_CREATE].includes(
                routesStore.current
            )
        },
        galleryItemIds() {
            return (uuids: Array<string>): Array<number> => {
                return this.galleryItemList
                    .filter((item) => uuids.includes(item.uuid))
                    .map((item) => item.id)
            }
        },
    },
    actions: {
        setEntities(entities: Array<GalleryItemListItem>): void {
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
        setEntity(entity: GalleryItem | null): void {
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
        addOrUpdateGalleryItemListItems(
            listItems: Array<GalleryItemListItem>
        ): void {
            let newItemById = arrayToMap<GalleryItemListItem>(listItems)

            this._entities = this._entities.map((item: GalleryItemListItem) => {
                let newListItem = newItemById[item.id]

                if (newListItem) {
                    listItems = listItems.filter((it) => it.id !== item.id)
                    return newListItem
                }

                return item
            })

            this._entities = [...this._entities, ...listItems]
        },
        async deleteBulkGalleryItems(
            checkedGalleryItemsUuids: Array<string>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedGalleryItemsUuids.length) {
                return
            }

            const routesStore = useRoutesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_GALLERY_ITEMS_BULK_DELETE
                    )
                )
                const checkedGalleryItemsIds = this.galleryItemIds(
                    checkedGalleryItemsUuids
                )
                checkedGalleryItemsIds.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                this.removeEntities(checkedGalleryItemsUuids)
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
