import { defineStore } from "pinia"
import {
    Article,
    ArticleListItem,
} from "@/admin/inertia/modules/articles/types"
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

export const storeName = "articles"

interface State {
    _entities: Array<ArticleListItem>
    _entity: Article | null
    _links: Links | null
    _meta: Meta | null
    _options: Array<Option>
}

export const useArticlesStore = defineStore(storeName, {
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
        articlesList: (state: State): Array<ArticleListItem> => state._entities,
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
        article: (state: State): Article | null => state._entity,
        options: (state: State): Array<Option> => state._options,
        optionsWithoutEntity: (state: State): Array<Option> =>
            state._options.filter(
                (option) => `${option.value}` !== `${state._entity?.id}`
            ),
        option() {
            return (articleId: string | number): Option | null => {
                let option = this.options.find(
                    (o: Option) => `${o.value}` === `${articleId}`
                )
                return option ? option : null
            }
        },
        isCreatingArticleRoute(): boolean {
            let routesStore = useRoutesStore()

            return [routeNames.ROUTE_ADMIN_ARTICLES_INDEX].includes(
                routesStore.current
            )
        },
        articleIds() {
            return (uuids: Array<string>): Array<number> => {
                return this.articlesList
                    .filter((item) => uuids.includes(item.uuid))
                    .map((item) => item.id)
            }
        },
    },
    actions: {
        setEntities(entities: Array<ArticleListItem>): void {
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
        setEntity(entity: Article | null): void {
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
        addOrUpdateArticlesListItems(listItems: Array<ArticleListItem>): void {
            let newItemById = arrayToMap<ArticleListItem>(listItems)

            this._entities = this._entities.map((item: ArticleListItem) => {
                let newListItem = newItemById[item.id]

                if (newListItem) {
                    listItems = listItems.filter((it) => it.id !== item.id)
                    return newListItem
                }

                return item
            })

            this._entities = [...this._entities, ...listItems]
        },
        async deleteBulkArticles(
            checkedArticlesUuids: Array<string>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedArticlesUuids.length) {
                return
            }

            const routesStore = useRoutesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_ARTICLE_BULK_DELETE
                    )
                )
                const checkedArticlesIds = this.articleIds(checkedArticlesUuids)
                checkedArticlesIds.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                this.removeEntities(checkedArticlesUuids)
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
