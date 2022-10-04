import { Order } from "@/admin/inertia/modules/orders/types"

export interface Values extends Partial<Omit<Order, 'user_id' | 'user_name' | 'user_email' | 'user_phone' | 'cancelled' | 'cancelled_description' | 'initial_attachments' | 'payment_method_attachments' | 'admin_name' | 'admin_color' | 'created_at' | 'dt_created_at' | 'updated_at' | 'dt_updated_at' | 'is_busy_by_other_admin' | 'busy_by_name'>> {}
