import { ArticleListItem } from "@/admin/inertia/modules/articles/types"

export interface Values {
    articles: Array<Partial<ArticleListItem>>
}

export interface ArticlesResponse {
    data: Array<ArticleListItem>
}
