<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineOptions({
    layout: (h, page) => {
        return h(AppLayout, {
            title: 'Menus',
        }, () => h(page))
    }
})
</script>

<template>
    Developing...
</template>
