<script lang="ts" setup>
import {useBlacklistStore} from "@/admin/inertia/modules/blacklist"
import RowInput from '@/admin/inertia/components/forms/vee-validate/RowInput.vue'
import IpDetails from '@/admin/inertia/components/parts/IpDetails.vue'

const blacklistStore = useBlacklistStore()
</script>

<template>
    <div class="item-edit product-edit">
        <div v-if="!blacklistStore.isCreatingBlacklistRoute" class="row mb-3">
            <div class="col-sm-5 text-end">
                ID:
            </div>
            <div class="col-sm-7">
                {{ blacklistStore.blacklist?.id }}
            </div>
        </div>

        <RowInput
            name="email"
            label="Email"
        />

        <RowInput
            name="ip"
            label="Ip"
        />

        <div class="row mb-3">
            <div class="col-sm-5 text-end">
                IP детали:
            </div>
            <div class="col-sm-7">
                <IpDetails v-if="blacklistStore.blacklist?.ipDetails" :ip-details="blacklistStore.blacklist?.ipDetails" />
            </div>
        </div>
    </div>
</template>
