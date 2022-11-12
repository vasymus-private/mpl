export interface Admin {
    id: number
    name: string | null
    color: string | null
}

export interface User {
    id: number | null
    name: string | null
    email: string | null
    phone: string | null
    is_anonymous: boolean | null
    is_super_admin: boolean | null
}

export interface Auth {
    user: User
}
