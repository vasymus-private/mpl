import { defineStore } from "pinia"
import { Service } from "@/admin/inertia/modules/services/Service"

export const storeName = "services"

export const useServicesStore = defineStore(storeName, {
    state: (): { entities: Array<Service> } => {
        return {
            entities: [],
        }
    },
    actions: {
        setEntities(entities: Array<Service>): void {
            this.entities = entities
        },
    },
})
