export default interface User {
    id: number | null
    name: string | null
    email: string | null
    phone: string | null
    is_anonymous: boolean | null
    is_super_admin: boolean | null
}
