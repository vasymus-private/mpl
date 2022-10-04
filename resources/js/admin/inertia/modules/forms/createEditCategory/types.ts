import { Category } from "@/admin/inertia/modules/categories/types"

export interface Values extends Partial<Omit<Category, "products">> {}
