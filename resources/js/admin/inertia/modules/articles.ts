import { defineStore } from "pinia"
import Article from "@/admin/inertia/entities/Article"

export const storeName = "articles"

export const useArticlesStore = defineStore(storeName, {
    state: (): { entities: Array<Article> } => {
        return {
            entities: [],
        }
    },
    actions: {
        setEntities(entities: Array<Article>): void {
            this.entities = entities
        },
    },
})