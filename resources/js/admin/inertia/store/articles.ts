import { defineStore } from "pinia"
import Article from "@/admin/inertia/entities/Article";

export const ARTICLES_STORE = 'articles'

export const useArticlesStore = defineStore(ARTICLES_STORE, {
    state: (): { entities: Array<Article>; } => {
        return {
            entities: []
        }
    },
    actions: {
        setEntities(entities: Array<Article>): void {
            this.entities = entities
        }
    }
})
