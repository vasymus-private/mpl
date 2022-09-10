export interface Errors {
    [key: string]: Array<string>
}

export interface WithId {
    id: string | number
}

export interface Seo {
    title: string | null
    h1: string | null
    keywords: string | null
    description: string | null
}

export interface ErrorResponse {
    data: {
        errors: Errors
    }
}
