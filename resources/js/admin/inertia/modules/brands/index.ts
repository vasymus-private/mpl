import { defineStore } from "pinia"
import { Brand, BrandListItem } from "@/admin/inertia/modules/brands/types"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import { ErrorResponse, Links, Option, Meta } from "@/admin/inertia/modules/common/types"
import {
    errorsToErrorFields,
    extendMetaLinksWithComputedData,
} from "@/admin/inertia/modules/common"
import { arrayToMap } from "@/admin/inertia/utils"

export const storeName = "brands"

interface State {
    _entities: Array<BrandListItem>
    _links: Links | null
    _meta: Meta | null
    _entity: Brand | null
    _options: Array<Option>
}

export const useBrandsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _entities: [],
            _links: null,
            _meta: null,
            _entity: null,
            _options: [],
        }
    },
    getters: {
        brandsList: (state: State): Array<BrandListItem> => state._entities,
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
        brand: (state: State): Brand | null => state._entity,
        options: (state: State): Array<Option> => state._options,
        nullableOptions(): Array<Option> {
            return [
                {
                    value: null,
                    label: "Производитель",
                },
                ...this.options,
            ]
        },
        option() {
            return (brandId: string | number): Option | null => {
                let option = this.options.find(
                    (o: Option) => `${o.value}` === `${brandId}`
                )
                return option ? option : null
            }
        },
        isCreatingBrandRoute(): boolean {
            let routesStore = useRoutesStore()

            return [
                routeNames.ROUTE_ADMIN_BRANDS_CREATE,
                routeNames.ROUTE_ADMIN_BRANDS_TEMP_CREATE,
            ].includes(routesStore.current)
        },
        brandIds() {
            return (uuids: Array<string>): Array<number> => {
                return this.brandsList.filter(item => uuids.includes(item.uuid)).map(item => item.id)
            }
        }
    },
    actions: {
        setEntities(brandList: Array<BrandListItem>): void {
            this._entities = brandList
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
        setEntity(brand: Brand | null): void {
            this._entity = brand
        },
        setOptions(options: Array<Option>): void {
            this._options = options
        },
        removeEntities(uuids: Array<string>): void {
            this._entities = this._entities.filter(
                (item) => !uuids.includes(item.uuid)
            )
        },
        addOrUpdateBrandsListItems(listItems: Array<BrandListItem>): void {
            let newItemById = arrayToMap<BrandListItem>(listItems)

            this._entities = this._entities.map((item: BrandListItem) => {
                let newListItem = newItemById[item.id]

                if (newListItem) {
                    listItems = listItems.filter((it) => it.id !== item.id)
                    return newListItem
                }

                return item
            })

            this._entities = [...this._entities, ...listItems]
        },
        async deleteBulkBrands(
            checkedBrandsUuids: Array<string>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedBrandsUuids.length) {
                return
            }

            const routesStore = useRoutesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_BRANDS_BULK_DELETE
                    )
                )
                const checkedBrandIds = this.brandIds(checkedBrandsUuids)
                checkedBrandIds.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                this.removeEntities(checkedBrandsUuids)
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
