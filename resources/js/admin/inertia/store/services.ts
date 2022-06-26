import { defineStore } from "pinia"
import { Service } from "@/admin/inertia/entities/Service"

export const SERVICES_STORE = "services"

export const useServicesStore = defineStore(SERVICES_STORE, {
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
