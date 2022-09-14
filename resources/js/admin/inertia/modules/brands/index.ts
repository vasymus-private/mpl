import { defineStore } from "pinia"
import Option from "@/admin/inertia/modules/common/Option"
import {Brand, BrandListItem} from "@/admin/inertia/modules/brands/types"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import axios, {AxiosError} from "axios"
import {ErrorResponse} from "@/admin/inertia/modules/common/types"
import {errorsToErrorFields} from "@/admin/inertia/modules/common"

export const storeName = "brands"

interface State {
    _entities: Array<BrandListItem>
    _entity: Brand|null
    _options: Array<Option>
}

export const useBrandsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _entities: [],
            _entity: null,
            _options: [],
        }
    },
    getters: {
        brandsList: (state: State): Array<BrandListItem> => state._entities,
        brand: (state: State): Brand|null => state._entity,
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
    },
    actions: {
        setEntities(brandList: Array<BrandListItem>): void {
            this._entities = brandList
        },
        setEntity(brand: Brand|null): void {
            this._entity = brand
        },
        setOptions(options: Array<Option>): void {
            this._options = options
        },
        removeEntities(ids: Array<number>): void {
            this._entities = this._entities.filter(
                (item) => !ids.includes(item.id)
            )
        },
        async deleteBulkBrands(
            checkedBrands: Array<number>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedBrands.length) {
                return
            }

            const routesStore = useRoutesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_BRANDS_BULK_DELETE
                    )
                )
                checkedBrands.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                this.removeEntities(checkedBrands)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    return errorsToErrorFields(errors)
                }
                throw e
            }
        }
    },
})
