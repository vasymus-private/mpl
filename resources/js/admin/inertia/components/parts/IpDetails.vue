<script lang="ts" setup>
import {IpDetails} from "@/admin/inertia/modules/common/types"

const props = defineProps<{
    ipDetails: IpDetails
}>()
</script>

<template>
    <div>
        <p :style="{color: props.ipDetails.in_blacklist ? 'red' : 'inherit'}">{{ props.ipDetails.ip }}</p>
        <p v-if="props.ipDetails.country_a2" :title="props.ipDetails.country_name">{{ props.ipDetails.country_a2 }}</p>
        <p v-if="props.ipDetails.country_img">
            <img :src="props.ipDetails.country_img" alt="" />
        </p>
        <p v-if="props.ipDetails.city">{{ props.ipDetails.city }}</p>
    </div>
</template>
