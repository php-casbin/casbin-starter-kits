<script setup>

import Badge from "@/Components/Badge.vue";

const props = defineProps({
    id: Number,
    list: Array,
    capacity: Number
})
</script>

<template>
    <Badge v-for="o in list.slice(0, capacity)">{{o.name}}</Badge>
    <Badge :data-tooltip-target="'tooltip-o-' + id" data-tooltip-style="light" data-tooltip-placement="bottom" v-if="list.length > capacity">+{{list.length - capacity}}</Badge>
    <div :id="'tooltip-o-' + id" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
        <span v-for="rest in list.slice(capacity)">{{rest.name}}<br/></span>
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</template>
