<script setup>
const props = defineProps({
    value: Number,
    title: String
})
</script>

<template>
    <div class="bg-white p-6 rounded-lg flex flex-col">
        <span class="text-3xl font-semibold text-gray-800">{{ value }}</span>
        <span class="text-gray-500">{{ title }}</span>
    </div>
</template>
