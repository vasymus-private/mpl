<script lang="ts" setup>
import {useOrdersStore} from "@/admin/inertia/modules/orders"


const ordersStore = useOrdersStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div class="h5 text-center bg-info py-2">
            История изменений
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Операция</th>
                    <th scope="col">Описание</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="orderEvent in ordersStore.orderEvents" :key="orderEvent.id">
                    <td>
                        <span class="main-grid-cell-content">{{ orderEvent.dt_created_at ? orderEvent.dt_created_at.toFormat('dd.LL.yyyy HH:mm:ss') : null }}</span>
                    </td>
                    <td>
                        <span class="main-grid-cell-content">{{ orderEvent.userName }}</span>
                    </td>
                    <td>
                        <span class="main-grid-cell-content">{{ orderEvent.operation }}</span>
                    </td>
                    <td>
                        <span class="main-grid-cell-content">{{ orderEvent.description }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
